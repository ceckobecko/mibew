/**
 * @preserve Copyright 2005-2013 the original author or authors.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may obtain a copy of the License at
 *     http://www.apache.org/licenses/LICENSE-2.0
 */

(function(Mibew){

    /**
     * @class Base class for message models
     */
    Mibew.Models.Message = Mibew.Models.Base.extend(
        /** @lends Mibew.Models.Message.prototype */
        {
            /**
             * Default values of model
             */
            defaults : {
                /**
                 * Message kind. See Mibew.Models.Message.KIND_* for details
                 * @type Number
                 */
                kind: null,

                /**
                 * Unix timestamp when message was created
                 * @type Number
                 */
                created: 0,

                /**
                 * Name of the message sender
                 * @type String
                 */
                name: '',

                /**
                 * Text of the message
                 * @type String
                 */
                message: ''
            },

            /** Message kind constants */

            /** Message sent by user. */
            KIND_USER: 1,

            /** Message sent by operator */
            KIND_AGENT: 2,

            /** Hidden system message to operator */
            KIND_FOR_AGENT: 3,

            /** System messages for user and operator */
            KIND_INFO: 4,

            /** Message for user if operator have connection problems */
            KIND_CONN: 5,

            /** System message about some events (like rename). */
            KIND_EVENTS: 6,

            /** Message sent by a plugin */
            KIND_PLUGIN: 7

            /** End of message kind constants */
        }
    );

})(Mibew);