<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style media="screen">
        @font-face {
            font-family: 'Google Sans';
            font-style: normal;
            font-weight: 400;
            src: local('Google Sans Regular'), local('GoogleSans-Regular'), url(//fonts.gstatic.com/s/googlesans/v9/4UaGrENHsxJlGDuGo1OIlL3Kwp5eKQtGBlc.woff2)format('woff2');
            unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }

        @font-face {
            font-family: 'Google Sans';
            font-style: normal;
            font-weight: 400;
            src: local('Google Sans Regular'), local('GoogleSans-Regular'), url(//fonts.gstatic.com/s/googlesans/v9/4UaGrENHsxJlGDuGo1OIlL3Nwp5eKQtGBlc.woff2)format('woff2');
            unicode-range: U+0370-03FF;
        }

        @font-face {
            font-family: 'Google Sans';
            font-style: normal;
            font-weight: 400;
            src: local('Google Sans Regular'), local('GoogleSans-Regular'), url(//fonts.gstatic.com/s/googlesans/v9/4UaGrENHsxJlGDuGo1OIlL3Awp5eKQtGBlc.woff2)format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        @font-face {
            font-family: 'Google Sans';
            font-style: normal;
            font-weight: 400;
            src: local('Google Sans Regular'), local('GoogleSans-Regular'), url(//fonts.gstatic.com/s/googlesans/v9/4UaGrENHsxJlGDuGo1OIlL3Owp5eKQtG.woff2)format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        @font-face {
            font-family: 'Google Sans';
            font-style: normal;
            font-weight: 500;
            src: local('Google Sans Medium'), local('GoogleSans-Medium'), url(//fonts.gstatic.com/s/googlesans/v9/4UabrENHsxJlGDuGo1OIlLU94Yt3CwZsPF4oxIs.woff2)format('woff2');
            unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }

        @font-face {
            font-family: 'Google Sans';
            font-style: normal;
            font-weight: 500;
            src: local('Google Sans Medium'), local('GoogleSans-Medium'), url(//fonts.gstatic.com/s/googlesans/v9/4UabrENHsxJlGDuGo1OIlLU94YtwCwZsPF4oxIs.woff2)format('woff2');
            unicode-range: U+0370-03FF;
        }

        @font-face {
            font-family: 'Google Sans';
            font-style: normal;
            font-weight: 500;
            src: local('Google Sans Medium'), local('GoogleSans-Medium'), url(//fonts.gstatic.com/s/googlesans/v9/4UabrENHsxJlGDuGo1OIlLU94Yt9CwZsPF4oxIs.woff2)format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        @font-face {
            font-family: 'Google Sans';
            font-style: normal;
            font-weight: 500;
            src: local('Google Sans Medium'), local('GoogleSans-Medium'), url(//fonts.gstatic.com/s/googlesans/v9/4UabrENHsxJlGDuGo1OIlLU94YtzCwZsPF4o.woff2)format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
    </style>
    <script type="text/javascript">
        var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ); ?>',
            ski_wtfa_nonce = '<?php echo $_GET['ski_wtfa_nonce'] ?>';
    </script>
    <?php do_action( 'admin_enqueue_scripts', 'ski-wtfa-setup' ); ?>
    <?php do_action( 'admin_print_styles' ); ?>
    <?php do_action( 'admin_head' ); ?>
</head>
<body>
    <script type="text/javascript">
    	document.body.className = document.body.className.replace('no-js','js');
    </script>
    <div id="ski-wtfa-setup">
        <form id="ski-wtfa-setup-form">
            <div class="header">
                <h1 class="title">Setup 2-step Verification</h1>
                <h5 class="sub-title">Secure Your Account With 2-step Verification</h5>
            </div>
            <div class="body">
                <div id="qr-secret-wrapper">
                    <div id="qr-code-container">
                        <img src="<?php echo $qr_code_url; ?>">
                    </div>
                    <div id="qr-secret-container">
                        <span><?php echo $totp_secret_formated; ?></span>
                    </div>
                </div>
                <div id="pin-input-container">
                    <div class="input-group">
                        <input type="text"
                               pattern="[0-9]{1}"
                               maxlength="1"
                               placeholder="&bull;"
                               autofocus>
                        <input type="text"
                               pattern="[0-9]{1}"
                               maxlength="1"
                               placeholder="&bull;">
                        <input type="text"
                               pattern="[0-9]{1}"
                               maxlength="1"
                               placeholder="&bull;">
                        <input type="text"
                               pattern="[0-9]{1}"
                               maxlength="1"
                               placeholder="&bull;">
                        <input type="text"
                               pattern="[0-9]{1}"
                               maxlength="1"
                               placeholder="&bull;">
                        <input type="text"
                               pattern="[0-9]{1}"
                               maxlength="1"
                               placeholder="&bull;">
                    </div>
                </div>
            </div>
            <div class="footer">
                <a href="<?php echo admin_url( 'profile.php' ); ?>"
                   class="button danger-link">Cancel</a>
                <button type="submit"
                        class="button primary"
                        disabled>Verify</button>
            </div>
        </form>
    </div>
    <?php do_action( 'in_admin_footer' ); ?>
    <?php do_action( 'admin_footer', '' ); ?>
    <?php do_action( 'admin_print_footer_scripts' ); ?>
</body>
</html>
