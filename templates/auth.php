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
            <span class="ma_method_icon">📱</span>
            <span class="ma_method_title">ارسال کد یکبار مصرف</span>
            <span class="ma_method_desc">کد از طریق پیامک ارسال می‌شود</span>
        </a>
        
        <a href="<?php echo site_url('/auth?step=password&mobile=' . urlencode($mobile)); ?>" class="ma_method_card">
            <span class="ma_method_icon">🔑</span>
            <span class="ma_method_title">ورود با رمز عبور</span>
            <span class="ma_method_desc">از رمز عبور خود استفاده کنید</span>
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
    <?php endif; ?>

    <form method="post" class="ma_form">
        <input type="hidden" name="mobile" value="<?php echo esc_attr($mobile); ?>">
        <input type="text" name="code" placeholder="کد 6 رقمی" required class="ma_input">
        <button type="submit" name="verify_reset_code" class="ma_button">تایید کد</button>
    </form>

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

    <h2 class="ma_title">کد ارسال شده را وارد کن</h2>

    <?php if (isset($_GET['err']) && $_GET['err'] == 'wrong'): ?>
        <p class="ma_error">کد درست نيست</p>
    <?php endif; ?>

    <form method="post" class="ma_form">
        <input type="hidden" name="mobile" value="<?php echo $mobile; ?>">
        <input type="text" name="code" placeholder="کد 6 رقمي" required class="ma_input">
        <button type="submit" name="verify_otp" class="ma_button">تاييد</button>
    </form>

<?php endif; ?>

</div>

<?php get_footer(); ?>
