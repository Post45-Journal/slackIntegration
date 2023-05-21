{**
 * templates/settings.tpl
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2003-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * Settings form for the slackIntegration plugin.
 *}
<script>
	$(function() {ldelim}
		$('#slackIntegrationSettings').pkpHandler('$.pkp.controllers.form.AjaxFormHandler');
	{rdelim});

	// rebase this out! need to send the test message from the backend. leaving it for now for reference
	// <!-- Uncertain about the right selector (templating seems to add a postfix to the element id) NEED TO DO THIS from the backend!!! -->
	// $('button#slackWebhookTest').click(sendTestMessage);
	


	// const webhookInput = $('.slackWebhookURL');

	// async function sendTestMessage(e) {ldelim}
	// 	e.preventDefault();
	// 	const url = webhookInput.val();
	// 	const response = await fetch(url, {ldelim}
	// 		method: 'POST',
	// 		mode: 'cors',
	// 		headers: {ldelim}
	// 			'Content-Type': 'application/json'
	// 		{rdelim},
	// 		body: {ldelim}
	// 			'text': 'OJS Slack Integration Test Message'
	// 		{rdelim},
	// 	{rdelim});
	// {rdelim};

</script>

<form
	class="pkp_form"
	id="slackIntegrationSettings"
	method="POST"
	action="{url router=$smarty.const.ROUTE_COMPONENT op="manage" category="generic" plugin=$pluginName verb="settings" save=true}"
>
	<!-- Always add the csrf token to secure your form -->
	{csrf}
	<div id="description">{translate key="plugins.generic.slackIntegration.manager.settings.description"}</div>
	{fbvFormArea}
		{fbvFormSection label="plugins.generic.slackIntegration.slackWebhookURL"}
			{fbvElement
				type="text"
				id="slackWebhookURL"
				class="slackWebhookURL"
				value=$slackWebhookURL
				description="plugins.generic.slackInteration.slackWebhookURL.description"
			}
		<button id="slackWebhookTest">Send a test message</button>
		{/fbvFormSection}
	{/fbvFormArea}
	{fbvFormButtons submitText="common.save"}
</form>
