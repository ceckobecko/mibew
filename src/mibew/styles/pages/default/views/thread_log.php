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

function tpl_header($page) {
?>

<!-- External libs -->
<script type="text/javascript" src="<?php echo MIBEW_WEB_ROOT ?>/js/libs/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo MIBEW_WEB_ROOT ?>/js/libs/json2.js"></script>
<script type="text/javascript" src="<?php echo MIBEW_WEB_ROOT ?>/js/libs/underscore-min.js"></script>
<script type="text/javascript" src="<?php echo MIBEW_WEB_ROOT ?>/js/libs/backbone-min.js"></script>
<script type="text/javascript" src="<?php echo MIBEW_WEB_ROOT ?>/js/libs/backbone.marionette.min.js"></script>
<script type="text/javascript" src="<?php echo MIBEW_WEB_ROOT ?>/js/libs/handlebars.js"></script>

<!-- Application files -->
<script type="text/javascript" src="<?php echo MIBEW_WEB_ROOT ?>/js/compiled/mibewapi.js"></script>
<script type="text/javascript" src="<?php echo MIBEW_WEB_ROOT ?>/js/compiled/default_app.js"></script>
<script type="text/javascript" src="<?php echo MIBEW_WEB_ROOT ?>/js/compiled/thread_log_app.js"></script>

<!-- Start application -->
<script type="text/javascript"><!--
	jQuery(document).ready(function(){
		Mibew.Application.start({
			messages: <?php echo($page['threadMessages']); ?>
		});
	});
//--></script>
<?php }

function tpl_content($page) {
$chatthreadinfo = $page['thread_info'];
$chatthread = $page['thread_info']['thread'];
?>

<?php echo getlocal("thread.intro") ?>

<br/><br/>

<div class="logpane">
<div class="header">

		<div class="wlabel">
			<?php echo getlocal("page.analysis.search.head_name") ?>:
		</div> 
		<div class="wvalue">
			<?php echo to_page(htmlspecialchars($chatthread->userName)) ?>
		</div>
		<br clear="all"/>
		
		<div class="wlabel">
			<?php echo getlocal("page.analysis.search.head_host") ?>:
		</div>
		<div class="wvalue">
			<?php echo get_user_addr(to_page($chatthread->remote)) ?>
		</div>
		<br clear="all"/>

		<div class="wlabel">
			<?php echo getlocal("page.analysis.search.head_browser") ?>:
		</div>
		<div class="wvalue">
			<?php echo get_user_agent_version(to_page($chatthread->userAgent)) ?>
		</div>
		<br clear="all"/>

		<?php if( $chatthreadinfo['groupName'] ) { ?>
			<div class="wlabel">
				<?php echo getlocal("page.analysis.search.head_group") ?>:
			</div>
			<div class="wvalue">
				<?php echo to_page(htmlspecialchars($chatthreadinfo['groupName'])) ?>
			</div>
			<br clear="all"/>
		<?php } ?>

		<?php if( $chatthread->agentName ) { ?>
			<div class="wlabel">
				<?php echo getlocal("page.analysis.search.head_operator") ?>:
			</div>
			<div class="wvalue">
				<?php echo to_page(htmlspecialchars($chatthread->agentName)) ?>
			</div>
			<br clear="all"/>
		<?php } ?>

		<div class="wlabel">
			<?php echo getlocal("page.analysis.search.head_time") ?>:
		</div>
		<div class="wvalue">
			<?php echo date_diff_to_text($chatthread->modified-$chatthread->created) ?>
				(<?php echo date_to_text($chatthread->created) ?>)
		</div>
		<br clear="all"/>
</div>

<div class="message" id="messages-region"></div>
</div>

<br />
<a href="<?php echo MIBEW_WEB_ROOT ?>/operator/history.php">
	<?php echo getlocal("thread.back_to_search") ?></a>
<br />


<?php 
} /* content */

require_once(dirname(__FILE__).'/inc_main.php');
?>