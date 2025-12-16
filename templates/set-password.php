<?php
if (!defined('ABSPATH')) exit;
get_header();

$mobile = isset($_GET['mobile']) ? sanitize_text_field($_GET['mobile']) : '';
?>

<div class="ma_container">

    <h2 class="ma_title">تنظیم رمز عبور</h2>
    
    <p style="color: #6b7280; margin-bottom: 20px; font-family: 'Vazirmatn', sans-serif;">
        برای امنیت بیشتر حساب کاربری، لطفا یک رمز عبور انتخاب کنید
    </p>

    <?php if (isset($_GET['err'])): ?>
        <?php if ($_GET['err'] == 'mismatch'): ?>
            <p class="ma_error">رمز عبور و تکرار آن یکسان نیستند</p>
        <?php elseif ($_GET['err'] == 'short'): ?>
            <p class="ma_error">رمز عبور باید حداقل ۶ کاراکتر باشد</p>
        <?php endif; ?>
    <?php endif; ?>

    <form method="post" class="ma_form">
        <input type="hidden" name="mobile" value="<?php echo esc_attr($mobile); ?>">
        
        <input 
            type="password" 
            name="password" 
            placeholder="رمز عبور (حداقل ۶ کاراکتر)" 
            required 
            class="ma_input"
            minlength="6"
        >
        
        <input 
            type="password" 
            name="password_confirm" 
            placeholder="تکرار رمز عبور" 
            required 
            class="ma_input"
            minlength="6"
        >
        
        <button type="submit" name="set_password" class="ma_button">ذخیره و ادامه</button>
    </form>

</div>

<?php get_footer(); ?>
