<div id ="contents">

    <div class="inner">
        <div class="accountBox clearfix">
            <--{FRONT_INC_LOGIN_MENU_HTML}-->
        </div>
        <section>

            <h2><--{__('lbl_rsv_login_change_cancel')}--></h2>
            <h4 style="color: red;">
                <--{$error}-->
            </h4>

            <div class="loginBox cancelBox">
                <div class="inputBox">
                    <p><--{__('lbl_rsv_login_change_cancel_desc')}--></p>
                    <--{Form::open($action)}-->
                        <div class="inputForm">
                            <dl>
                                <dt><--{__('lbl_rsv_login_change_cancel_rsv_no')}--></dt>
                                <dd><input type="text" name="reserve_num" id="reserveNum01"></dd>
                            </dl>
                            <dl>
                                <dt><--{__('lbl_mailaddress')}--></dt>
                                <dd><input type="email" name="reserve_mail" id="reserveMail01"></dd>
                            </dl>
                        </div>
                        <p class="btn"><input type="submit" value="予約確認"></p>
                    <--{Form::close()}-->
                </div>
            </div>

        </section>
    </div>

</div>
