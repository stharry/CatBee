<?php

class MailChimpTemplateAdapter
{
    private $currentTemplate;
    private $currentField;
    private $parentField;
    private $supportedTextFieldNames;

    function __construct()
    {
        $this->supportedTextFieldNames = array(
            'td', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'a', 'span', 'div'
        );
    }

    private function printHierarchy($node, $tab)
    {
        //return;
        echo $tab.$node->nodeName;
        if ($node->nodeType == XML_TEXT_NODE) {echo $node->nodeValue;}
        echo '</p>';

        foreach ($node->childNodes as $childNode)
        {

            $this->printHierarchy($childNode, $tab.'___ ');

        }
    }

    public function convertToTribziTemplate($dom, $rootId)
    {
        $this->currentTemplate = new Template();

        if (isset($rootId))
        {
            $tables = array($dom->getElementById($rootId));
        }
        else
        {
            $tables = $dom->getElementsByTagName('body');
        }

        if (isset($tables) && (count($tables) > 0))
        {
            foreach ($tables as $table)
            {
                $this->printHierarchy($table, '');
                foreach ($table->childNodes as $node)
                {
                    $this->parseNode($node);
                }
            }
        }
        else{
            echo "No elements";
        }

        //under consruction $this->removeEmptySections();

        return $this->currentTemplate;
    }

    private function scanChildren($node)
    {
        //echo "scan children for ".$node->nodeName.' parent '.$node->parentNode->nodeName.'</p>';

        if ($node->hasChildNodes())
        {
            $fld = $this->currentField;
            foreach ($node->childNodes as $childNode)
            {

                $this->parseNode($childNode);

            }
            $this->currentField = $fld;

            //echo 'after children '.$node->nodeName.'</p>';
            //echo 'curr field returned: '. $this->currentField->name.'</p>';
        }

    }

    private function setFieldProps($node)
    {
        $this->fillStyleProps($this->currentField->style, $node);
        $this->scanChildren($node);
    }

    private function setNewCurrentField($name, $type)
    {
        if (!isset($this->currentField))
        {
            $this->currentField = $this->currentTemplate->addField();

        }
        else
        {
            $this->parentField = $this->currentField;
            $this->currentField = $this->currentField->addChild();
        }
        $this->currentField->name = $name;
        $this->currentField->type = $type;

        //echo 'curr field: '. $this->currentField->name.'</p>';
    }

    private function parseNode($node)
    {
        $fld = $this->currentField;
        if ($this->isImageField($node->nodeName))
        {
            $this->setNewCurrentField($node->nodeName, 'image');
            $this->setFieldProps($node);
            $this->currentField->source = $this->currentField->style->attributes['src'];
            $this->currentField->style->deleteAttribute('src');
            //echo 'image node '.$node->nodeName.' val '.$node->nodeValue.'<br>';
        }
        else if ($this->isLineField($node->nodeName))
        {
            $this->setNewCurrentField($node->nodeName, 'line');
            //echo 'line node '.$node->nodeName.' val '.$node->nodeValue.'<br>';
        }
        else if ($this->isCaretField($node->nodeName))
        {
            if (isset($this->currentField))
            {
                $this->currentField->source .= '{lb}';
                //echo 'text for text node '.$node->nodeValue.'<br>';
            }
        }
        else if (($node->nodeType == XML_TEXT_NODE))
        {

            $this->setNewCurrentField($node->nodeName, 'text');
            $this->currentField->name = 'span';
            $this->currentField->source = $this->removeTabs($this->removeSpecCharacters($node->nodeValue));
//            if (isset($this->currentField))
//            {
//                $this->currentField->source .= $this->removeSpecCharacters($node->nodeValue);
//                //echo 'text for text node '.$node->nodeValue.' curr is: '.$this->currentField->name.'<br>';
//            }
        }
        else if ($this->isCommentNode($node->nodeName))
        {
            //do not do noting
        }
        else if ($this->isBoldNode($node->nodeName))
        {
            $this->currentField->source .= '<strong>' . $this->removeSpecCharacters($node->nodeValue) . '</strong>';
            //echo 'strong for text node '.$node->nodeValue.' curr is: '.$this->currentField->name.'<br>';
        }
        else
        {

            $this->setNewCurrentField($node->nodeName, 'text');
            $this->setFieldProps($node);

            //echo 'text node '.$node->nodeName.' val '.$node->nodeValue.'<br>';
        }
        $this->currentField = $fld;

    }

    private function fillStyleProps($style, $node)
    {
        if ($node->hasAttributes())
        {
            foreach ($node->attributes as $attribute)
            {
                if ($attribute->name == 'style')
                {
                    $stylePairs = explode(';', $attribute->value);
                    foreach ($stylePairs as $stylePair)
                    {
                        if ($stylePair != '')
                        {
                            $nameVal = explode(':', $stylePair);
                            $style->addElement($nameVal[0], trim($nameVal[1]));
                        }
                    }
                }
                else if ($attribute->name == 'href')
                {
                    if (isset($this->currentField) && (!empty($attribute->value)))
                    {
                        $this->currentField->linkSource = $attribute->value;
                    }
                }
                else
                {
                    $style->addAttribute($attribute->name, $attribute->value);
                }
            }
        }
    }

    public function isSupportedTextField($fieldName)
    {
        if (in_array($fieldName, $this->supportedTextFieldNames))
        {
            return true;
        }

        return false;
    }

    private function isLineField($fieldName)
    {
        return $fieldName == 'hr';
    }

    private function isCaretField($fieldName)
    {
        return false; //$fieldName == 'br';
    }

    private function isImageField($fieldName)
    {
        return $fieldName == 'img';
    }

    private function isCommentNode($fieldName)
    {
        return $fieldName == '#comment';
    }

    private function isBoldNode($fieldName)
    {
        return $fieldName == 'strong';
    }

    private function removeSpecCharacters($string)
    {
        return str_replace("\\u00a0", "", $string);
    }

    private function removeTabs($string)
    {
        return str_replace("\n", '', str_replace("\t", '', $string));
    }

}
