<% if $LeftContent %>
	<section class="text-block">
		<div class="text-block__wrap text-block__wrap--column text-block__wrap--{$Width}">
			
			<div class="text-block__wrap--column__left">
				{$LeftContent}
			</div>
			
			<div class="text-block__wrap--column__right">
				{$RightContent}
			</div>

		</div>
	</section>
<% end_if %>