<?php

class CatBeeApiCommandRouter implements ICatBeeApiCommandRouter
{
    public function routeRequest($api)
    {
        $restRequest = RestUtils::processRequest();
        if (!$restRequest)
        {
            RestLogger::log(' request format is not valid ');
            die($api." request format is not valid ");

        }
        $action = $restRequest->getCatBeeAction();
        $context = $restRequest->getCatBeeContext();
        $app = $restRequest->getCatBeeCredentials();

        if ($this->applicationAccessDenied($app, $api, $action))
        {
            RestUtils::sendFailedResponse('Access denied');

        }
        else
        {
            RestLogger::log("$api API $action context is ", $context);

            $contextObj = $this->deserializeContext($api, $action, $context);

            $commandProcessor = $this->getCommandProcessor($api, $action);
            $resultObj = $commandProcessor->processCommand($contextObj);

            if ($resultObj)
            {
                $result = $this->serializeResult($api, $action, $resultObj);
                RestUtils::sendSuccessResponse($result);
            }
        }
    }

    private function applicationAccessDenied($app, $api, $action)
    {
        return false;
    }

    private function deserializeContext($api, $action, $context)
    {
    }

    private function getCommandProcessor($api, $action)
    {
    }

    private function serializeResult($api, $action, $resultObj)
    {
    }
}
