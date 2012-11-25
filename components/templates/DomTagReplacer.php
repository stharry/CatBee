<?php

class DomTagReplacer
{
    public function replaceTagsInDOM($dom)
    {
        $dit = new RecursiveIteratorIterator(
            new RecursiveDOMIterator($dom),
            RecursiveIteratorIterator::SELF_FIRST);

        foreach($dit as $node)
        {

//            if ($node->nodeType == XML_TEXT_NODE)
//            {
//                $tags = $this->getNodeTags($node->nodeValue);
//
//                if (!$tags)
//                {
//
//                }
//                else if ($this->isLoopRoot($tags[0]))
//                {
//                    $loopCnt = $this->calcLoopCount($tags[0]);
//
//
//                    $this->cloneChilds
//                }
//            }
                echo "$node->nodeName Node value: $node->nodeValue type: $node->nodeType<br />";

//            if ($node->attributes)
//            {
//                foreach ($node->attributes as $attr) {
//                    $name = $attr->name;
//                    $value = $attr->value;
//                    echo "Attribute '$name' :: '$value'<br />";
//                }
//            }
//            else
//            {
//                echo "$node->nodeName has no attributes <br />";
//
//            }
        }
    }
}
