# Installation Guide

Complete step-by-step guide to install and configure Lade Stack RSVP Widget.

---

## Table of Contents

1. [Prerequisites](#prerequisites)
2. [Installation Methods](#installation-methods)
3. [Initial Configuration](#initial-configuration)
4. [EmailJS Setup](#emailjs-setup)
5. [Adding to Pages](#adding-to-pages)
6. [Customization](#customization)
7. [Troubleshooting](#troubleshooting)

---

## Prerequisites

Before installing, ensure you have:

- ✅ WordPress 5.0 or higher
- ✅ PHP 7.4 or higher
- ✅ WordPress admin access
- ✅ Modern web browser (Chrome, Firefox, Safari, Edge)

### Recommended
- HTTPS/SSL enabled on your site
- Caching plugin (WP Rocket, W3 Total Cache)
- Backup plugin installed

---

## Installation Methods

### Method 1: WordPress Admin (Easiest)

1. **Log in to WordPress Admin**
   - Go to `yoursite.com/wp-admin`

2. **Navigate to Plugins**
   - Click **Plugins** → **Add New**

3. **Search for Plugin**
   - Type "Lade Stack RSVP" in search box
   - Look for plugin by "Lade Stack"

4. **Install**
   - Click **Install Now**
   - Wait for installation to complete

5. **Activate**
   - Click **Activate**
   - Plugin is now ready!

### Method 2: Upload ZIP File

1. **Download Plugin**
   - Download `lade-stack-rsvp.zip` from WordPress.org or GitHub

2. **Go to Upload Page**
   - WordPress Admin → Plugins → Add New
   - Click **Upload Plugin** button

3. **Choose File**
   - Click **Choose File**
   - Select `lade-stack-rsvp.zip`
   - Click **Install Now**

4. **Activate**
   - Click **Activate Plugin**

### Method 3: FTP Upload

1. **Unzip Plugin**
   - Extract `lade-stack-rsvp.zip` on your computer

2. **Connect via FTP**
   - Use FileZilla or similar FTP client
   - Connect to your server

3. **Upload Folder**
   - Navigate to `/wp-content/plugins/`
   - Upload `lade-stack-rsvp` folder

4. **Activate in WordPress**
   - Go to WordPress Admin → Plugins
   - Find "Lade Stack RSVP Widget"
   - Click **Activate**

---

## Initial Configuration

### Step 1: Access Settings

1. Go to **Settings** → **Lade Stack RSVP**
2. Configure default options (optional)

### Step 2: Set Admin Password

**IMPORTANT:** Change default password!

1. Go to Settings → Lade Stack RSVP
2. Enter new **Admin Password**
3. Click **Save Changes**

Default: `ladestack123`  
**Change this immediately for security!**

### Step 3: Configure EmailJS (Optional but Recommended)

See [EmailJS Setup](#emailjs-setup) below.

---

## EmailJS Setup

### Step 1: Create EmailJS Account

1. Go to [EmailJS.com](https://www.emailjs.com/)
2. Click **Sign Up** (free)
3. Choose free plan (200 emails/month)
4. Verify email address

### Step 2: Add Email Service

1. In EmailJS Dashboard, click **Email Services**
2. Click **Add New Service**
3. Choose your provider (Gmail, Outlook, etc.)
4. Connect your account
5. Copy **Service ID** (e.g., `service_gmail123`)

### Step 3: Create Email Template

1. Click **Email Templates** → **Create New Template**
2. Use this template:

```
Subject: RSVP Confirmation for {{event_name}}

Hello {{name}},

Your RSVP for {{event_name}} has been confirmed!

📅 Date: {{event_date}} {{event_time}}
📍 Location: {{event_location}}
👥 Guests: {{guests}}
🍽️ Dietary: {{dietary}}

Scan your QR code below for entry:
{{qrUrl}}

See you there!
Lade Stack Events
```

3. Save template
4. Copy **Template ID** (e.g., `template_rsvp456`)

### Step 4: Get Public Key

1. Click your name (top right) → **Account**
2. Go to **API Keys** section
3. Copy **Public Key** (e.g., `user_abc123xyz`)

### Step 5: Add to WordPress

1. Go to WordPress Admin → Settings → Lade Stack RSVP
2. Enter:
   - **EmailJS Service ID**: `service_xxx`
   - **EmailJS Template ID**: `template_xxx`
   - **EmailJS Public Key**: `user_xxx`
3. Click **Save Changes**

---

## Adding to Pages

### Using Gutenberg Block (Recommended)

1. **Edit Page/Post**
   - Open any page or post in editor

2. **Add Block**
   - Click **+** button
   - Search "Lade Stack RSVP"
   - Select the block

3. **Configure Settings**
   - Use right sidebar to configure:
     - Event name, date, time, location
     - Max capacity
     - Deadline
     - Approval mode
     - EmailJS settings
     - Theme (light/dark)

4. **Publish/Update**
   - Click **Publish** or **Update**

### Using Shortcode

1. **Edit Page/Post**
   - Open in classic or block editor

2. **Add Shortcode**
   ```
   [lade_rsvp_widget event-name="My Event"]
   ```

3. **Full Configuration**
   ```
   [lade_rsvp_widget 
       event-name="Annual Gala 2026"
       event-date="2026-06-15"
       event-time="7:00 PM"
       event-location="Grand Ballroom, NYC"
       max-capacity="200"
       deadline="2026-06-10"
       approval-mode="true"
       admin-password="yourpassword"
       emailjs-service="service_xxx"
       emailjs-template="template_xxx"
       emailjs-key="user_xxx"
       theme="light"
       fields="name,email,phone,guests,dietary"
   ]
   ```

---

## Customization

### Change Colors

Use `custom-css` attribute:

```
[lade_rsvp_widget 
    custom-css='{"primary": "#ff6b6b", "success": "#48bb78"}'
]
```

### Available CSS Variables

```json
{
  "primary": "#667eea",
  "primary-hover": "#5a6fd6",
  "success": "#48bb78",
  "warning": "#ed8936",
  "danger": "#f56565",
  "bg-primary": "#e0e5ec",
  "text-primary": "#2d3748",
  "width": "420px",
  "height": "600px"
}
```

### Change Widget Position

```
[lade_rsvp_widget position="top-left"]
```

Options: `top-left`, `top-right`, `bottom-left`, `bottom-right`

### Enable Dark Theme

```
[lade_rsvp_widget theme="dark"]
```

### Multi-Language Support

```
[lade_rsvp_widget language="mr"]
```

Options: `en` (English), `mr` (Marathi)

### Google Analytics Tracking

```
[lade_rsvp_widget analytics-id="G-XXXXXXXXXX"]
```

---

## Troubleshooting

### Widget Not Appearing

**Problem:** Widget doesn't show on page

**Solutions:**
1. Clear browser cache (Ctrl+F5)
2. Check if plugin is activated
3. Verify shortcode syntax
4. Check browser console for errors

### Email Not Sending

**Problem:** Confirmation emails not being sent

**Solutions:**
1. Verify EmailJS credentials
2. Check EmailJS dashboard for errors
3. Ensure template variables match
4. Check spam folder

### Admin Dashboard Not Opening

**Problem:** Can't access admin dashboard

**Solutions:**
1. Verify password (default: `ladestack123`)
2. Clear browser cache
3. Check browser console for JavaScript errors
4. Try incognito/private mode

### Data Lost After Refresh

**Problem:** RSVPs disappear after page refresh

**Solutions:**
1. Check if browser allows localStorage
2. Disable private/incognito mode
3. Export CSV backups regularly
4. Enable email confirmations

### Mobile Issues

**Problem:** Widget doesn't work on mobile

**Solutions:**
1. Update to latest plugin version
2. Clear mobile browser cache
3. Try different mobile browser
4. Check if theme conflicts

### Performance Issues

**Problem:** Widget loads slowly

**Solutions:**
1. Enable caching plugin
2. Use CDN for assets
3. Reduce number of widgets per page
4. Check server response time

---

## Getting Help

### Documentation
- 📖 [Official Documentation](https://ladestack.in/docs)
- 🐛 [Bug Reports](https://github.com/girishlade111/WordPress-plugin-RSVP-Form/issues)
- 💬 [Support Forum](https://wordpress.org/support/plugin/lade-stack-rsvp)

### Contact
- Email: support@ladestack.in
- Website: https://ladestack.in

---

## Next Steps

After installation:

1. ✅ Change admin password
2. ✅ Set up EmailJS (optional)
3. ✅ Add widget to a test page
4. ✅ Test RSVP submission
5. ✅ Check admin dashboard
6. ✅ Export CSV backup
7. ✅ Configure Google Analytics (optional)
8. ✅ Customize colors/branding

---

**Congratulations!** Your RSVP widget is ready to collect responses! 🎉
