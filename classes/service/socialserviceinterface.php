<?php

namespace Lb\SocialPublish\Service;

interface SocialServiceInterface
{
    public function getName();
    
    public function isValid();
    
    public function publish();
}