# =================================================================
# LADE STACK RSVP WIDGET - CREDENTIALS DOCUMENTATION
# =================================================================
# ⚠️ SECURITY WARNING: This is a TEMPLATE only!
# - Replace bracketed placeholders with your actual values
# - NEVER commit actual credentials to version control
# - Store this file securely or delete after use
# =================================================================

## 📋 CREDENTIALS CHECKLIST

### 1. WordPress Admin Access
| Field | Your Value | Where to Find |
|-------|------------|---------------|
| **Admin Email** | `[YOUR_EMAIL]` | WordPress signup email |
| **Admin Username** | `[YOUR_USERNAME]` | WordPress Users → Profile |
| **Admin Password** | `[CHANGE_ME]` | Set during WordPress install |
| **Site URL** | `[YOUR_SITE_URL]` | WordPress Settings → General |

### 2. EmailJS Configuration (Required for Email Confirmations)
| Field | Your Value | Where to Find |
|-------|------------|---------------|
| **Service ID** | `[service_xxx]` | EmailJS Dashboard → Email Services |
| **Template ID** | `[template_xxx]` | EmailJS Dashboard → Email Templates |
| **Public Key** | `[user_xxx]` | EmailJS Dashboard → Account → API Keys |

**EmailJS Setup Steps:**
1. Sign up at https://www.emailjs.com/ (free tier: 200 emails/month)
2. Add Email Service (Gmail, Outlook, etc.)
3. Create Email Template with variables: `{{name}}`, `{{email}}`, `{{event_name}}`
4. Copy credentials to WordPress Admin → Lade Stack RSVP Settings

### 3. Google Analytics (Optional - For Event Tracking)
| Field | Your Value | Where to Find |
|-------|------------|---------------|
| **Tracking ID** | `[G-XXXXXXXXXX]` | Google Analytics → Admin → Data Streams |
| **Measurement ID** | `[G-XXXXXXXXXX]` | Google Analytics → Admin → Data Streams |

### 4. RSVP Admin Dashboard Password
| Field | Default Value | Recommended Change |
|-------|---------------|-------------------|
| **Admin Password** | `ladestack123` | `[YOUR_SECURE_PASSWORD]` |

**Change via:**
- WordPress Admin → Lade Stack RSVP Settings
- Or shortcode: `[lade_rsvp_widget admin-password="your-password"]`

### 5. Database Credentials (WordPress handles automatically)
| Field | Default | Notes |
|-------|---------|-------|
| **Database Name** | Auto-created | During WordPress install |
| **Database User** | Auto-created | During WordPress install |
| **Database Password** | Auto-created | During WordPress install |
| **Database Host** | `localhost` | Usually doesn't need change |

⚠️ **These are stored in `wp-config.php` - DO NOT modify unless necessary**

---

## 🔐 SECURE STORAGE OPTIONS

### Option 1: WordPress Admin Panel (RECOMMENDED)
```
WordPress Dashboard → Settings → Lade Stack RSVP
├── EmailJS Service ID
├── EmailJS Template ID
└── EmailJS Public Key
```
✅ Stored encrypted in WordPress database (wp_options table)

### Option 2: Environment Variables (.env file)
```bash
# Create .env in plugin root (NEVER commit to Git)
EMAILJS_SERVICE_ID=service_yourid
EMAILJS_TEMPLATE_ID=template_yourid
EMAILJS_PUBLIC_KEY=user_yourkey
RSVP_ADMIN_PASSWORD=your_secure_password
```

### Option 3: wp-config.php Constants
```php
// Add to wp-config.php (above "That's all, stop editing!")
define('EMAILJS_SERVICE_ID', 'service_yourid');
define('EMAILJS_TEMPLATE_ID', 'template_yourid');
define('EMAILJS_PUBLIC_KEY', 'user_yourkey');
define('RSVP_ADMIN_PASSWORD', 'your_secure_password');
```

---

## 🚫 SECURITY BEST PRACTICES

### ✅ DO:
- Use strong, unique passwords (12+ characters)
- Enable two-factor authentication (2FA) for WordPress admin
- Store credentials in WordPress Options API
- Use environment variables in production
- Rotate passwords every 90 days
- Use a password manager (1Password, Bitwarden, LastPass)

### ❌ DON'T:
- Store passwords in plain text files
- Commit credentials to Git/GitHub
- Share credentials via email or chat
- Use default passwords in production
- Reuse passwords across services
- Store credentials in code comments

---

## 📝 SHORTCODE USAGE WITH CREDENTIALS

```php
// Basic usage (credentials from WordPress Admin)
[lade_rsvp_widget event-name="My Event"]

// Override admin password per widget
[lade_rsvp_widget 
    event-name="My Event" 
    admin-password="custom-password"
]

// Full configuration
[lade_rsvp_widget 
    event-name="Annual Gala 2026"
    event-date="2026-06-15"
    max-capacity="100"
    emailjs-service="service_xxx"
    emailjs-template="template_xxx"
    emailjs-key="user_xxx"
    admin-password="your-secure-password"
    analytics-id="G-XXXXXXXXXX"
]
```

---

## 🔍 WHERE CREDENTIALS ARE STORED

| Credential | Storage Location | Encryption |
|------------|------------------|------------|
| EmailJS Keys | WordPress wp_options table | No (use HTTPS) |
| Admin Password | WordPress wp_options table | No (use strong password) |
| Google Analytics ID | WordPress wp_options table | No (public ID) |
| Database Credentials | wp-config.php | No (server-only access) |
| WordPress Salts | wp-config.php | No (server-only access) |

---

## 🛡️ SECURITY CHECKLIST

Before going live, verify:

- [ ] Changed default admin password from `ladestack123`
- [ ] EmailJS credentials entered in WordPress Admin (not hardcoded)
- [ ] .env file added to .gitignore
- [ ] wp-config.php not accessible via web browser
- [ ] WordPress admin uses strong password (12+ characters)
- [ ] Two-factor authentication enabled for admin users
- [ ] HTTPS/SSL enabled on WordPress site
- [ ] Regular backups configured
- [ ] Security plugin installed (Wordfence, Sucuri, etc.)

---

## 📞 SUPPORT

**Need Help?**
- EmailJS Setup: https://www.emailjs.com/docs/
- WordPress Security: https://wordpress.org/support/article/hardening-wordpress/
- Lade Stack Support: support@ladestack.in

**Report Security Issues:**
- Email: security@ladestack.in
- DO NOT disclose publicly until fixed

---

*Last Updated: 2026-03-09*  
*Version: 1.0.0*
