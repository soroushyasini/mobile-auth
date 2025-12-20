<?php
if (!defined('ABSPATH')) exit;
get_header();

$step = isset($_GET['step']) ? $_GET['step'] : 'start';
$mobile = isset($_GET['mobile']) ? sanitize_text_field($_GET['mobile']) : '';
?>

<div class="ma_container">

<?php if ($step === 'start'): ?>

    <h2 class="ma_title">ورود يا ثبت نام</h2>

    <?php if (isset($_GET['err']) && $_GET['err'] == 'format'): ?>
        <p class="ma_error">شماره درست نيست</p>
    <?php endif; ?>

    <form method="post" class="ma_form">
        <input type="text" name="mobile" placeholder="شماره موبايل" required class="ma_input">
        <button type="submit" name="send_otp" class="ma_button">ادامه</button>
    </form>

<?php elseif ($step === 'choose_method'): ?>

    <h2 class="ma_title">انتخاب روش ورود</h2>
    
    <p style="color: #6b7280; margin-bottom: 25px; font-family: 'Vazirmatn', sans-serif; font-size: 14px;">
        شماره: <strong><?php echo esc_html($mobile); ?></strong>
    </p>

    <div class="ma_method_cards">
        <a href="<?php echo site_url('/auth?step=verify&mobile=' . urlencode($mobile)); ?>" class="ma_method_card">
            <div class="ma_method_content">
                <div class="ma_method_text">
                    <span class="ma_method_title">ارسال کد یکبار مصرف</span>
                    <span class="ma_method_desc">کد از طریق پیامک ارسال می‌شود</span>
                </div>
                <div class="ma_method_icon_compact">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z"/>
                        <path d="M7 9h2v2H7zm4 0h2v2h-2zm4 0h2v2h-2z"/>
                    </svg>
                </div>
            </div>
        </a>
        
        <a href="<?php echo site_url('/auth?step=password&mobile=' . urlencode($mobile)); ?>" class="ma_method_card">
            <div class="ma_method_content">
                <div class="ma_method_text">
                    <span class="ma_method_title">ورود با رمز عبور</span>
                    <span class="ma_method_desc">ورود سریع بدون انتظار</span>
                </div>
                <div class="ma_method_icon_compact">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M12.65 10C11.7 7.31 8.9 5.5 5.77 6.12c-2.29.46-4.15 2.29-4.63 4.58C.32 14.57 3.26 18 7 18c2.61 0 4.83-1.67 5.65-4H17v2c0 1.1.9 2 2 2s2-.9 2-2v-2c1.1 0 2-.9 2-2s-.9-2-2-2h-8.35zM7 14c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
                    </svg>
                </div>
            </div>
        </a>
    </div>

<?php elseif ($step === 'password'): ?>

    <h2 class="ma_title">ورود با رمز عبور</h2>
    
    <p style="color: #6b7280; margin-bottom: 20px; font-family: 'Vazirmatn', sans-serif; font-size: 14px;">
        شماره: <strong><?php echo esc_html($mobile); ?></strong>
    </p>

    <?php if (isset($_GET['err']) && $_GET['err'] == 'wrong_password'): ?>
        <p class="ma_error">رمز عبور اشتباه است</p>
    <?php elseif (isset($_GET['err']) && $_GET['err'] == 'no_password'): ?>
        <p class="ma_error">رمز عبوری تنظیم نشده است. لطفا از روش ارسال کد استفاده کنید</p>
    <?php endif; ?>

    <form method="post" class="ma_form">
        <input type="hidden" name="mobile" value="<?php echo esc_attr($mobile); ?>">
        <input type="password" name="password" placeholder="رمز عبور" required class="ma_input">
        <button type="submit" name="login_password" class="ma_button">ورود</button>
    </form>
    
    <div style="margin-top: 20px;">
        <a href="<?php echo site_url('/auth?step=forgot_password&mobile=' . urlencode($mobile)); ?>" 
           style="color: #09375b; text-decoration: none; font-family: 'Vazirmatn', sans-serif; font-size: 14px; font-weight: 600;">
            رمز عبور را فراموش کرده‌اید؟
        </a>
    </div>
    
    <div style="margin-top: 15px;">
        <a href="<?php echo site_url('/auth?step=verify&mobile=' . urlencode($mobile)); ?>" 
           style="color: #6b7280; text-decoration: none; font-family: 'Vazirmatn', sans-serif; font-size: 13px;">
            ← ورود با کد یکبار مصرف
        </a>
    </div>

<?php elseif ($step === 'forgot_password'): ?>

    <h2 class="ma_title">بازیابی رمز عبور</h2>
    
    <p style="color: #6b7280; margin-bottom: 20px; font-family: 'Vazirmatn', sans-serif; font-size: 14px;">
        برای بازیابی رمز عبور، کد تایید به شماره <strong><?php echo esc_html($mobile); ?></strong> ارسال می‌شود
    </p>

    <form method="post" class="ma_form">
        <input type="hidden" name="mobile" value="<?php echo esc_attr($mobile); ?>">
        <button type="submit" name="send_reset_otp" class="ma_button">ارسال کد تایید</button>
    </form>

<?php elseif ($step === 'reset_password'): ?>

    <h2 class="ma_title">بازیابی رمز عبور</h2>
    
    <?php if (isset($_GET['err']) && $_GET['err'] == 'wrong_code'): ?>
        <p class="ma_error">کد تایید اشتباه است</p>
    <?php elseif (isset($_GET['err']) && $_GET['err'] == 'rate_limit'): ?>
        <?php
        $remaining = isset($_GET['remaining']) ? intval($_GET['remaining']) : 0;
        $minutes = floor($remaining / 60);
        $seconds = $remaining % 60;
        ?>
        <p class="ma_error">لطفا <?php echo $minutes; ?>:<?php echo str_pad($seconds, 2, '0', STR_PAD_LEFT); ?> دقیقه صبر کنید</p>
    <?php endif; ?>

    <?php
    // Check if there's an active rate limit
    $mobile_clean = convert_persian_numbers($mobile);
    $last_request = get_transient('otp_rate_limit_' . $mobile_clean);
    $show_countdown = false;
    $remaining_seconds = 0;
    
    if ($last_request !== false) {
        $remaining_seconds = 60 - (time() - $last_request);
        if ($remaining_seconds > 0) {
            $show_countdown = true;
        }
    }
    ?>

    <form method="post" class="ma_form">
        <input type="hidden" name="mobile" value="<?php echo esc_attr($mobile); ?>">
        <input type="text" name="code" placeholder="کد 6 رقمی" required class="ma_input">
        <button type="submit" name="verify_reset_code" class="ma_button">تایید کد</button>
    </form>

    <?php if ($show_countdown): ?>
        <div class="ma_countdown_container" id="countdown-container-reset">
            <p class="ma_countdown_text">درخواست مجدد کد پس از: <span id="countdown-timer-reset" class="ma_countdown_timer"></span></p>
        </div>
    <?php else: ?>
        <div class="ma_resend_container">
            <form method="post" style="display: inline;">
                <input type="hidden" name="mobile" value="<?php echo esc_attr($mobile); ?>">
                <button type="submit" name="send_reset_otp" class="ma_resend_button">ارسال مجدد کد</button>
            </form>
        </div>
    <?php endif; ?>

    <?php if ($show_countdown): ?>
    <script>
    (function() {
        var remainingSeconds = <?php echo $remaining_seconds; ?>;
        var countdownElement = document.getElementById('countdown-timer-reset');
        var containerElement = document.getElementById('countdown-container-reset');
        
        function convertToPersianNumber(num) {
            var persianDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            return num.toString().split('').map(function(digit) {
                return persianDigits[parseInt(digit)];
            }).join('');
        }
        
        function updateCountdown() {
            if (remainingSeconds <= 0) {
                // Countdown finished - show resend button
                containerElement.innerHTML = '<div class="ma_resend_container"><form method="post" style="display: inline;"><input type="hidden" name="mobile" value="<?php echo esc_attr($mobile); ?>"><button type="submit" name="send_reset_otp" class="ma_resend_button">ارسال مجدد کد</button></form></div>';
                return;
            }
            
            // Simple format: just show seconds with "ثانیه"
            var persianTimeString = ' ثانیه ' + convertToPersianNumber(remainingSeconds);
            
            countdownElement.textContent = persianTimeString;
            remainingSeconds--;
            
            setTimeout(updateCountdown, 1000);
        }
        
        updateCountdown();
    })();
    </script>
    <?php endif; ?>

<?php elseif ($step === 'new_password'): ?>

    <h2 class="ma_title">تنظیم رمز عبور جدید</h2>

    <?php if (isset($_GET['err'])): ?>
        <?php if ($_GET['err'] == 'mismatch'): ?>
            <p class="ma_error">رمز عبور و تکرار آن یکسان نیستند</p>
        <?php elseif ($_GET['err'] == 'short'): ?>
            <p class="ma_error">رمز عبور باید حداقل ۶ کاراکتر باشد</p>
        <?php endif; ?>
    <?php endif; ?>

    <form method="post" class="ma_form">
        <input type="hidden" name="mobile" value="<?php echo esc_attr($mobile); ?>">
        <input type="password" name="new_password" placeholder="رمز عبور جدید (حداقل ۶ کاراکتر)" required class="ma_input" minlength="6">
        <input type="password" name="new_password_confirm" placeholder="تکرار رمز عبور جدید" required class="ma_input" minlength="6">
        <button type="submit" name="reset_password" class="ma_button">ذخیره رمز عبور</button>
    </form>

<?php elseif ($step === 'verify'): ?>

    <h2 class="ma_title">کد ارسال شده را وارد کنید</h2>

    <?php if (isset($_GET['err']) && $_GET['err'] == 'wrong'): ?>
        <p class="ma_error">کد درست نيست</p>
    <?php elseif (isset($_GET['err']) && $_GET['err'] == 'rate_limit'): ?>
        <?php
        $remaining = isset($_GET['remaining']) ? intval($_GET['remaining']) : 0;
        $minutes = floor($remaining / 60);
        $seconds = $remaining % 60;
        ?>
        <p class="ma_error">لطفا <?php echo $minutes; ?>:<?php echo str_pad($seconds, 2, '0', STR_PAD_LEFT); ?> دقیقه صبر کنید</p>
    <?php endif; ?>

    <?php
    // Check if there's an active rate limit
    $mobile_clean = convert_persian_numbers($mobile);
    $last_request = get_transient('otp_rate_limit_' . $mobile_clean);
    $show_countdown = false;
    $remaining_seconds = 0;
    
    if ($last_request !== false) {
        $remaining_seconds = 60 - (time() - $last_request);
        if ($remaining_seconds > 0) {
            $show_countdown = true;
        }
    }
    ?>

    <form method="post" class="ma_form">
        <input type="hidden" name="mobile" value="<?php echo $mobile; ?>">
        <input type="text" name="code" placeholder="کد 6 رقمي" required class="ma_input">
        <button type="submit" name="verify_otp" class="ma_button">تاييد</button>
    </form>

    <?php if ($show_countdown): ?>
        <div class="ma_countdown_container" id="countdown-container">
            <p class="ma_countdown_text">درخواست مجدد کد پس از: <span id="countdown-timer" class="ma_countdown_timer"></span></p>
        </div>
    <?php else: ?>
        <div class="ma_resend_container">
            <a href="<?php echo site_url('/auth?step=verify&mobile=' . urlencode($mobile)); ?>" class="ma_resend_link">ارسال مجدد کد</a>
        </div>
    <?php endif; ?>

    <?php if ($show_countdown): ?>
    <script>
    (function() {
        var remainingSeconds = <?php echo $remaining_seconds; ?>;
        var countdownElement = document.getElementById('countdown-timer');
        var containerElement = document.getElementById('countdown-container');
        
        function convertToPersianNumber(num) {
            var persianDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            return num.toString().split('').map(function(digit) {
                return persianDigits[parseInt(digit)];
            }).join('');
        }
        
        function updateCountdown() {
            if (remainingSeconds <= 0) {
                // Countdown finished - show resend button
                containerElement.innerHTML = '<div class="ma_resend_container"><a href="<?php echo site_url('/auth?step=verify&mobile=' . urlencode($mobile)); ?>" class="ma_resend_link">ارسال مجدد کد</a></div>';
                return;
            }
            
            // Simple format: just show seconds with "ثانیه"
            var persianTimeString = ' ثانیه '+ convertToPersianNumber(remainingSeconds);
            
            countdownElement.textContent = persianTimeString;
            remainingSeconds--;
            
            setTimeout(updateCountdown, 1000);
        }
        
        updateCountdown();
    })();
    </script>
    <?php endif; ?>

<?php endif; ?>

</div>

<?php get_footer(); ?>
