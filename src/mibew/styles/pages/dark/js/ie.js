/*!
 * This file is a part of Mibew Messenger.
 *
 * Copyright 2005-2021 the original author or authors.
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

(function(window, document) {
    var mkwidth = function(){
        if(document.getElementById("wrap700")) {
            document.getElementById("wrap700").style.width = (document.documentElement.clientWidth < 750)
                ? "750px"
                : "100%";
        }
        if(document.getElementById("wrap400")) {
            document.getElementById("wrap400").style.width = (document.documentElement.clientWidth < 450)
                ? "450px"
                : "100%";
        }
    };

    window.attachEvent('onload', mkwidth);
    window.attachEvent('onresize', mkwidth);
})(window, document);