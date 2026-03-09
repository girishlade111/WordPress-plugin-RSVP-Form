# 🎉 Lade Stack RSVP Widget

**Version:** 1.0.0  
**Author:** Lade Stack  
**Website:** https://ladestack.in  
**License:** GPL v2 or later

A free, AI-powered, client-side RSVP widget for WordPress. No database required - uses localStorage for data persistence. Features draggable form, live capacity counter, QR code generation, EmailJS integration, and admin dashboard.

---

## ✨ Features

### Core Features
- 🖱️ **Draggable & Resizable Widget** - Move anywhere on page with interact.js
- 📊 **Live Capacity Counter** - Real-time spot tracking with animations
- 📝 **Toggleable Form Fields** - Name, Email, Phone, Guests (1-10), Dietary Preferences
- ⏳ **Waitlist Mode** - Auto-shows when event reaches capacity
- ⏰ **RSVP Deadline** - Countdown timer with auto-close
- 🔐 **Approval Mode** - Pending/Approved/Rejected workflow
- 📧 **Email Confirmation** - EmailJS integration for automatic emails
- 📱 **QR Code Generation** - Unique QR per RSVP for check-in
- 📥 **CSV Export** - Download all RSVPs instantly
- 🎨 **Neumorphic Design** - Modern shadcn-inspired UI
- 🌙 **Dark/Light Theme** - Auto-detect or manual toggle
- 📱 **Mobile Responsive** - Perfect on all devices
- ♿ **Accessible** - ARIA labels, keyboard navigation
- 🔁 **Cross-Tab Sync** - Real-time updates across browser tabs

### Technical Features
- **Zero Database** - Uses localStorage for persistence
- **Pure Vanilla JS** - No React/Vue/jQuery dependencies
- **CDN Libraries** - interact.js, EmailJS, QRCode.js, FileSaver.js
- **Shortcode Based** - Easy WordPress integration
- **Lightweight** - <100KB total size
- **Fast Load** - <3s page load time

---

## 🚀 Installation

### Method 1: WordPress Admin
1. Download the plugin folder
2. Go to WordPress Admin → Plugins → Add New
3. Upload the `lade-stack-rsvp.zip` file
4. Click "Activate Now"

### Method 2: FTP
1. Upload `lade-stack-rsvp` folder to `/wp-content/plugins/`
2. Activate the plugin in WordPress Admin → Plugins

---

## 📋 Shortcode Usage

### Basic Usage
```
[lade_rsvp_widget]
```

### With Event Details
```
[lade_rsvp_widget 
    event-name="Solapur Tech Meetup 2026"
    event-date="2026-04-15"
    event-time="7:00 PM"
    event-location="Dhondewadi Hall, Solapur"
    max-capacity="100"]
```

### Custom Fields
```
[lade_rsvp_widget 
    fields="name,email,guests"
    max-capacity="50"]
```

Available fields: `name`, `email`, `phone`, `guests`, `dietary`

### Approval Mode
```
[lade_rsvp_widget 
    approval-mode="true"
    admin-password="ladestack123"]
```

### With Deadline
```
[lade_rsvp_widget 
    deadline="2026-04-01"
    event-date="2026-04-15"]
```

### EmailJS Integration
```
[lade_rsvp_widget 
    emailjs-service="service_abc123"
    emailjs-template="template_xyz789"
    emailjs-key="user_def456"]
```

### Full Example
```
[lade_rsvp_widget 
    event-name="Lade Stack Launch Party"
    event-date="2026-05-01"
    event-time="8:00 PM"
    event-location="Mumbai Convention Center"
    max-capacity="200"
    waitlist-enabled="true"
    fields="name,email,phone,guests,dietary"
    deadline="2026-04-25"
    approval-mode="false"
    admin-password="ladestack2026"
    emailjs-service="service_abc123"
    emailjs-template="template_xyz789"
    emailjs-key="user_def456"
    theme="light"
    position="bottom-right"
    show-branding="true"]
```

---

## 📧 EmailJS Setup Guide

### Step 1: Create Account
1. Go to https://www.emailjs.com/
2. Sign up for free account (1000 emails/month free)

### Step 2: Add Email Service
1. Click "Email Services" → "Add New Service"
2. Choose your provider (Gmail, Outlook, etc.)
3. Connect your account
4. Copy the **Service ID**

### Step 3: Create Email Template
1. Click "Email Templates" → "Create New Template"
2. Use this template:

```
Subject: RSVP Confirmation - {{event_name}}

Hello {{name}},

Your RSVP has been confirmed!

📅 Event: {{event_name}}
🗓️ Date: {{event_date}} {{event_time}}
📍 Location: {{event_location}}
👥 Guests: {{guests}}
🍽️ Dietary: {{dietary}}

RSVP ID: {{rsvp_id}}

See you there!
Lade Stack Team
```

3. Copy the **Template ID**

### Step 4: Get Public Key
1. Go to "Account" → "API Keys"
2. Copy your **Public Key**

### Step 5: Add to Shortcode
```
[lade_rsvp_widget 
    emailjs-service="YOUR_SERVICE_ID"
    emailjs-template="YOUR_TEMPLATE_ID"
    emailjs-key="YOUR_PUBLIC_KEY"]
```

---

## 🎨 Customization

### Change Colors
Edit the CSS variables in `includes/widget.php`:

```css
:root {
    --lade-primary: #667eea;        /* Main accent color */
    --lade-success: #48bb78;        /* Success/available spots */
    --lade-warning: #ed8936;        /* Low spots warning */
    --lade-danger: #f56565;         /* Full/error state */
    --lade-bg-primary: #e0e5ec;     /* Main background */
}
```

### Change Widget Position
```
[lade_rsvp_widget position="top-left"]
```

Available positions: `top-left`, `top-right`, `bottom-left`, `bottom-right`

### Enable Dark Theme
```
[lade_rsvp_widget theme="dark"]
```

### Hide Branding
```
[lade_rsvp_widget show-branding="false"]
```

---

## 🎯 Admin Dashboard

### Access Dashboard
1. Click the ⚙️ button on the widget
2. Enter admin password (default: `admin`)
3. View RSVP list and statistics

### Dashboard Features
- **Stats Cards** - Total, Approved, Pending, Waitlist counts
- **RSVP Table** - Sortable list of all RSVPs
- **Bulk Actions** - Approve all pending RSVPs
- **CSV Export** - Download all data
- **Clear Data** - Delete all RSVPs for event

### Approval Workflow
1. Enable approval mode in shortcode
2. New RSVPs get "pending" status
3. Admin reviews in dashboard
4. Approve/Reject individual RSVPs
5. Only approved RSVPs get QR code and email

---

## 📊 Data Storage

### LocalStorage Keys
- `lade_rsvp_[event-id]` - Main RSVP data
- `lade_rsvp_widget_state` - Widget position/minimized state

### Data Structure
```json
{
    "rsvps": [
        {
            "id": "rsvp_1234567890_abc123",
            "name": "John Doe",
            "email": "john@example.com",
            "phone": "+1234567890",
            "guests": 2,
            "dietary": ["Vegetarian"],
            "status": "approved",
            "timestamp": "2026-03-09T10:30:00Z",
            "qrData": "..."
        }
    ],
    "waitlist": [],
    "approved": ["rsvp_1234567890_abc123"],
    "rejected": []
}
```

### Cross-Tab Sync
Widget automatically syncs across browser tabs using StorageEvent.

---

## 🧪 Testing

### Local Testing
1. Open `test-widget.html` in browser
2. Test all features without WordPress
3. Use browser DevTools to inspect localStorage

### Test Scenarios
- [ ] Drag widget around page
- [ ] Resize from bottom-right corner
- [ ] Fill form and submit
- [ ] Verify QR code downloads
- [ ] Check localStorage persistence
- [ ] Test admin dashboard (password: `admin`)
- [ ] Export CSV
- [ ] Test waitlist (set max-capacity="1")
- [ ] Test deadline (set past date)
- [ ] Test approval mode

---

## 🔧 Troubleshooting

### Widget Not Showing
- Ensure shortcode is added correctly
- Check browser console for errors
- Verify CDN scripts are loading

### Drag Not Working
- Check if interact.js is loaded
- Ensure no JavaScript errors
- Try different browser

### Email Not Sending
- Verify EmailJS credentials
- Check EmailJS dashboard for errors
- Ensure template variables match

### QR Code Not Generating
- Check if QRCode.js is loaded
- Verify browser supports canvas
- Clear browser cache

### Data Not Persisting
- Check if localStorage is enabled
- Ensure no private/incognito mode
- Clear and retry

---

## 📁 File Structure

```
lade-stack-rsvp/
├── lade-stack-rsvp.php    # Main plugin file
├── includes/
│   └── widget.php         # Widget HTML/CSS/JS
├── test-widget.html       # Local test page
├── README.md              # This file
└── assets/                # (Optional custom assets)
```

---

## 🔒 Security

### Input Sanitization
- All user inputs are escaped with `escapeHtml()`
- No `eval()` or `innerHTML` with user data
- Regex validation for email/phone

### XSS Prevention
- Content Security Policy compatible
- No inline scripts with user data
- Sanitized shortcode attributes

### Best Practices
- No sensitive data in localStorage
- Password protection for admin panel
- No server-side code (client-side only)

---

## 📈 Performance

### Bundle Size
- Total: <100KB (gzipped)
- CSS: ~35KB
- JS: ~45KB
- HTML: ~5KB

### Load Time
- First load: <3s
- Subsequent: <1s (cached)

### Optimization Tips
- CDN scripts are cached
- Lazy load not needed (single widget)
- Minimal DOM manipulation

---

## 🤝 Support

### Documentation
- Full docs: https://ladestack.in/docs/rsvp-widget
- Video tutorials: https://ladestack.in/tutorials

### Contact
- Email: support@ladestack.in
- Website: https://ladestack.in

### Issues
- GitHub: https://github.com/girishlade111/WordPress-plugin-RSVP-Form

---

## 📝 Changelog

### Version 1.0.0 (2026-03-09)
- Initial release
- Draggable/resizable widget
- Live capacity counter
- Toggleable form fields
- Waitlist mode
- Deadline countdown
- Approval workflow
- EmailJS integration
- QR code generation
- CSV export
- Admin dashboard
- Cross-tab sync
- Neumorphic design
- Mobile responsive

---

## 📄 License

GPL v2 or later

Copyright © 2026 Lade Stack

---

## 🙏 Credits

- **interact.js** - Drag and drop functionality
- **EmailJS** - Client-side email sending
- **QRCode.js** - QR code generation
- **FileSaver.js** - CSV download
- **Design Inspiration** - shadcn/ui, Tailwind CSS

---

Made with ❤️ by Lade Stack | https://ladestack.in
