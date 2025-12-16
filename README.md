# 🔐 Mobile Auth

WordPress plugin for mobile-based authentication with OTP and password support. 

## 📖 Description

Mobile Auth provides a seamless login and registration experience using mobile phone numbers.  Users can authenticate via SMS OTP or password, offering flexibility and speed.

## ✨ Features

### Authentication Methods
- 📱 **Mobile OTP Authentication** - Secure SMS-based verification
- 🔑 **Password Login** - Fast login without waiting for SMS
- 🔄 **Dual Method Support** - Users choose their preferred method
- ✅ **Auto Registration** - New users automatically registered on first OTP

### User Experience
- ⚡ **Instant Password Login** - No SMS delays
- 🌐 **Persian/Farsi Interface** - Full RTL support
- 🔢 **Persian Number Conversion** - Handles both Persian and English digits
- 📱 **Mobile-First Design** - Responsive and modern UI
- ↪️ **Smart Redirects** - Remember where users wanted to go

### Security & Management
- 🔒 **Forced Password Setup** - New users must set password
- 🆘 **Password Reset via OTP** - Forgot password recovery
- 🔑 **Admin Backdoor** - Secret admin access (`? admin_key=hn`)
- ⏱️ **30-Day Sessions** - Persistent login
- 🛡️ **WordPress Security Standards** - Native password hashing

### Integration
- 📧 **WooCommerce Compatible** - Works with My Account pages
- 📮 **Kavenegar SMS API** - Reliable OTP delivery
- 🎨 **Custom Styling** - Clean, professional design
- 🔌 **Easy Setup** - Automatic page creation on activation

## 🚀 Installation

1. Upload the plugin files to `/wp-content/plugins/mobile-auth/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Plugin automatically creates `/auth` and `/secret-admin-login` pages
4. Configure your Kavenegar API key in `mobile-auth.php` (line 100)

## 📋 Requirements

- WordPress 5.0+
- PHP 7.0+
- WooCommerce (optional, for profile integration)
- Kavenegar SMS account

## 🎯 Usage

### For New Users
1. Enter mobile number (09xxxxxxxxx format)
2. Receive and enter OTP code
3. **Set password** (required)
4. Redirected to profile page

### For Returning Users
1. Enter mobile number
2. Choose login method:
   - 📱 **Send OTP** - Receive SMS code
   - 🔑 **Use Password** - Instant login
3. Complete authentication

### Password Management
- Users can change passwords in **My Account → Edit Account**
- Forgot password?  Use OTP verification to reset

## 💰 Benefits

| Feature | OTP Only | With Password |
|---------|----------|---------------|
| Login Speed | 30-60 seconds | 2 seconds ⚡ |
| Works Offline | ❌ | ✅ |
| SMS Cost | Every login | Only registration |
| User Experience | Wait required | Instant access |

**Estimated SMS Cost Savings:** 50-80% reduction

## 🛠️ Configuration

### SMS API Setup
Edit line 100 in `mobile-auth.php` with your Kavenegar API key: 
```php
$url = "https://api.kavenegar.com/v1/YOUR_API_KEY_HERE/verify/lookup. json?" . 
```

### Admin Access
- Standard login:  `yoursite.com/wp-login.php?admin_key=hn`
- Change the key in line 54 to customize

## 📝 Changelog

### Version 1.2.0 (2025-12-16)
**🔑 Password Authentication Update**

#### Added
- ✨ **Password login option** - Users can now login with password instead of waiting for OTP
- 🔒 **Forced password setup** - New users must set a password during first registration
- 🔄 **Login method selection** - Choose between OTP or Password on each login
- 🔑 **Password management** - Change password in account settings
- 🆘 **Forgot password flow** - Reset password via OTP verification
- 📱 **Dual authentication** - Both OTP and password methods work simultaneously

#### Benefits
- ⚡ **Faster logins** - Instant access with password (no SMS wait)
- 💰 **Reduced SMS costs** - Up to 50% savings when users choose password
- 📶 **Works offline** - Login even without SMS signal
- 😊 **Better UX** - Users choose their preferred method

---

### Version 1.1.0 (2025-12-01)
**Initial Release**

#### Features
- 📱 Mobile-based authentication (Iranian format:  09xxxxxxxxx)
- 🔐 OTP verification via SMS (Kavenegar API)
- ✅ Combined login/register on single page
- 🔄 Auto-registration for new users
- 🌐 Persian/Farsi UI with number conversion
- 🔒 Admin backdoor with secret key
- ↪️ Smart redirect handling
- 🎨 Modern, responsive design
- ⏱️ 30-day session persistence

## 🏷️ Version Numbering

We follow [Semantic Versioning](https://semver.org/): **MAJOR.MINOR.PATCH**

- **MAJOR** (1.x.x) - Breaking changes
- **MINOR** (x. 2.x) - New features, backward compatible
- **PATCH** (x.x.1) - Bug fixes

**Current Version:** `1.2.0`

## 📁 File Structure

```
mobile-auth/
├── mobile-auth.php              # Main plugin file
├── README.md                    # Documentation
├── assets/
│   └── style.css               # UI styling
└── templates/
    ├── auth. php                # Main authentication page
    ├── set-password.php        # Password setup (new users)
    └── forgot-password.php     # Password reset flow
```

## 🔒 Security

- Passwords hashed using WordPress native functions (`wp_hash_password()`)
- OTP codes expire after 3 minutes (180 seconds)
- Mobile numbers stored uniquely (prevents duplicates)
- Session cookies:  30-day expiration
- CSRF protection via WordPress nonces
- Input sanitization and validation

## 🌍 Supported Mobile Format

- **Iranian mobile numbers only:** `09xxxxxxxxx` (11 digits)
- Converts Persian/Arabic numerals to English automatically
- Validates format before sending OTP

## 👨‍💻 Developer

**Author:** Milad Karimi ( Ver 1.1 ) Soroush Yasini ( Ver 1.2)
**Version:** 1.2.0  
**License:** GPL-2.0+

## 🤝 Contributing

Contributions are welcome! Please feel free to submit pull requests or open issues.

## 📞 Support

For issues or questions: 
- Open an issue on GitHub
- Check existing documentation
- Review code comments

## 📄 License

This plugin is licensed under the GPL-2.0+ License. 

---

**Made with ❤️ for WordPress**

