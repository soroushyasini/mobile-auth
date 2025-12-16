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
