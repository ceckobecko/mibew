/**
 * @preserve Copyright 2005-2013 the original author or authors.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may obtain a copy of the License at
 *     http://www.apache.org/licenses/LICENSE-2.0
 */

/**
 * Represents User list Window to core interaction type
 *
 * @constructor
 */
MibewAPIUsersInteraction = function() {
    this.obligatoryArguments = {
        '*': {
            'agentId': null,
            'return': {},
            'references': {}
        },
        'result': {
            'errorCode': 0
        }
    };

    this.reservedFunctionNames = [
        'result'
    ];
}
MibewAPIUsersInteraction.prototype = new MibewAPIInteraction();