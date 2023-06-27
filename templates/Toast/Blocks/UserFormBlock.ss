<section class="text-block text-block--{$BackgroundColour}">
	<div class="text-block__wrap text-block__wrap--{$Width}">

		<% if $IsFinished %>
			<div class="message success">
				$FormSuccessMessage
			</div>
		<% end_if %>

		$Form
	</div>
</section>
