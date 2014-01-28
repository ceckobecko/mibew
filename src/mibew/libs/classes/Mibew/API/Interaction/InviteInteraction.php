<?php
/*
 * Copyright 2005-2013 the original author or authors.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Mibew\API\Interaction;

/**
 * Implements Mibew Core - Mibew invitation waiting window interaction
 */
class InviteInteraction extends Interaction
{
    /**
     * Reserved function's names
     * @var array
     * @see \Mibew\API\Interaction\Interaction::$reservedFunctionNames
     */
    public $reservedFunctionNames = array(
        'result',
    );

    /**
     * Defines obligatory arguments and default values for them
     * @var array
     * @see \Mibew\API\Interaction\Interaction::$obligatoryArgumnents
     */
    protected $obligatoryArguments = array(
        '*' => array(
            'references' => array(),
            'return' => array(),
            'visitorId' => null,
        ),
        'result' => array(
            'errorCode' => 0,
        ),
    );
}
