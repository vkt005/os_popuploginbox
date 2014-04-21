<!-- Block user login module -->
<div  class="block">
	{l s='Log in' mod='psblockuserlogin'}
    <div class="block_content">
		<ul id="block_user_login">
	  		<li>
	  			
            	{l s='Welcome' mod='psblockuserlogin'},
				{if $logged}
				<span>{$customerName}</span>(<a href="index.php?mylogout" class="highslide" title="{l s='Log me out' mod='psblockuserlogin'}"><img src="{$base_dir}modules/os_popuploginbox/login.png"/>&nbsp;{l s='Log out' mod='psblockuserlogin'}</a>)
				{else}
				<a href="#user-login-info"  class="fancybox"><img src="{$base_dir}modules/os_popuploginbox/login.png"/>&nbsp;&nbsp;{l s='Log in' mod='psblockuserlogin'}</a>
				{/if}
			</li>
		</ul>
    </div>
</div>
<div style="display: none"class=" col-xs-12 col-sm-12" id="user-login-info" >
    <div class="row">
        {if $OS_showcreateacct}
		<div class="col-xs-12 col-sm-6">
			<form action="{$link->getPageLink('authentication', true)|escape:'html'}" method="post" id="acreate-account_form" class="box">
                            <div class="alert alert-danger unvisible ca"></div>	
                            <h3 class="page-subheading">Create an account</h3>
				<div class="form_content clearfix">
					<p>Please enter your email address to create an account.</p>
					<div class="alert alert-danger" id="create_account_error" style="display:none"></div>
					<div class="form-group">
						<label for="email_create">Email address</label>
						<input type="text" class="is_required validate account_input form-control" data-validate="isEmail" id="email_create" name="email_create" value="">
					</div>
					<div class="submit">
						<input type="hidden" class="hidden" name="back" value="history">						
                                                <button class="btn btn-default button button-medium exclusive" type="button" id="SubmitCreate" name="SubmitCreate">
							<span>
								<i class="icon-user left"></i>
								Create an account
							</span>
						</button>
                                                 
						<input type="hidden" class="hidden" name="SubmitCreate" value="Create an account">
					</div>
				</div>
			</form>
		</div>
        {/if}
		<div class="col-xs-12 {if $OS_showcreateacct} col-sm-6{/if}">
			<form action="{$link->getPageLink('authentication', true)|escape:'html'}" method="post" id="os_login_form" class="box">
			 <div style="padding:5px" class="alert alert-danger unvisible alert-login"></div>
                         <h3 class="page-subheading">Login</h3>
                            <input type="hidden" name="SubmitLogin" value="SubmitLogin" />
                            <input type="hidden" name="ajax" value="ajax" />
				<div class="form_content clearfix">
					<div class="form-group">
						<label for="email">Email address</label>
						<input class="is_required validate account_input form-control" data-validate="isEmail" type="text" id="email" name="email" value="">
					</div>
					<div class="form-group">
						<label for="passwd">Password</label>
						<span><input class="is_required validate account_input form-control" type="password" data-validate="isPasswd" id="passwd" name="passwd" value=""></span>
					</div>
					<p class="lost_password form-group"><a href="{$link->getPageLink('password', true)|escape:'html'}" title="Recover your forgotten password" rel="nofollow">Forgot your password?</a></p>
					<p class="submit">
                                            <button type="button" id="SubmitLogin_ajax" name="SubmitLogin" class="button btn btn-default button-medium">
                                                <span>
                                                    <i class="icon-lock left"></i>
                                                    Sign in
                                                </span>
                                            </button>
					</p>
				</div>
			</form>
		</div>
	</div>
</div>
   {addJsDefL name=log_url}{$link->getPageLink('authentication', true)|escape:'html'}{/addJsDefL} 
   {addJsDefL name=log_myaccount_url}{$link->getPageLink('my-account', true)|escape:'html'}{/addJsDefL} 
   {addJsDefL name=caurl}{$base_dir}modules/os_popuploginbox/ajax-call.php{/addJsDefL} 
<!-- /Block user login module -->


