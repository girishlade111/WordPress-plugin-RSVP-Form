# 🎉 Lade Stack RSVP Widget

**Version:** 1.0.0  
**Author:** Lade Stack  
**License:** GPL v2 or later

Free AI-Powered Client-Side RSVP Widget for WordPress with Draggable Form, Live Capacity Counter, QR Codes, Email Confirmations, Admin Dashboard & CSV Export. No database required - uses localStorage.

---

## ✨ Features

### Phase 1-2: Core Widget
- 🖱️ **Draggable & Resizable** widget (interact.js)
- 🎨 **Neumorphic Design** with light/dark themes
- 📱 **Fully Responsive** - mobile, tablet, desktop
- ♿ **Accessibility Ready** - ARIA labels, keyboard navigation, screen reader support

### Phase 3: Capacity Management
- 📊 **Live Capacity Counter** with animated spots remaining
- 🎉 **Low Spots Alerts** - orange (<10), red (<5), celebration (last spot)
- ⏳ **Waitlist Mode** - automatically shows when event is full
- 🎊 **Confetti Animation** for low spots celebration

### Phase 4: Email Confirmation
- 📧 **EmailJS Integration** - send confirmation emails (free tier)
- 🎫 **QR Code in Email** - unique QR for each attendee
- ✅ **Success Toast** - green "Confirmation sent!" with shake animation
- ❌ **Error Retry** - red toast with retry button

### Phase 5: Deadline System
- ⏰ **Live Countdown Timer** - "RSVP closes in 3d 12h"
- 🔒 **Auto-Lock Form** - shows "RSVP Closed" at deadline
- 🚨 **Urgent Alert** - red pulsing pill when <24 hours
- 💾 **Storage Sync** - persists deadline state

### Phase 6: Admin Dashboard
- 🔐 **Password Protected** - default: `ladestack123`
- 📊 **Stats Overview** - Total | Approved | Pending | Waitlist
- 🔍 **Search & Filter** - by name/email, by status
- 📥 **CSV Export** - separate exports for RSVPs and Waitlist
- 🗑️ **Clear All Data** - reset widget data

### Phase 7: QR Codes + Approval
- 🎫 **Auto-Generate QR** - on approval with download
- ✅ **Approve/Reject** - individual or bulk actions
- 📧 **Resend Email** - sends confirmation on approve
- 📋 **Duplicate RSVP** - for no-shows or +1

### Phase 8: Production Polish
- 🌗 **Auto Dark Mode** - prefers-color-scheme detection
- 📱 **Touch-Friendly** - 44px minimum touch targets
- ♿ **WCAG 2.1 AA** - full keyboard navigation, focus management
- ⚡ **Performance** - lazy load CDNs, <100KB gzipped
- 🏷️ **Lade Stack Branding** - logo + ladestack.in footer link

---

## 🚀 Installation

### Method 1: Upload Plugin

1. Download the `lade-stack-rsvp` folder
2. Upload to `/wp-content/plugins/lade-stack-rsvp/`
3. Activate "Lade Stack RSVP Widget" in WordPress Admin → Plugins
4. Add shortcode to any page or post

### Method 2: Gutenberg Block

1. Install and activate the plugin
2. Edit any page/post in Gutenberg editor
3. Click **+ Add Block** → Search "Lade Stack RSVP"
4. Configure settings in the right sidebar

---

## 📋 Shortcode Usage

### Basic Example
```
[lade_rsvp_widget event-name="My Event" max-capacity="100"]
```

### Full Example
```
[lade_rsvp_widget 
    event-name="Annual Gala 2026"
    event-date="2026-06-15"
    event-time="7:00 PM"
    event-location="Grand Ballroom, NYC"
    max-capacity="200"
    fields="name,email,phone,guests,dietary"
    deadline="2026-06-10"
    approval-mode="true"
    admin-password="mysecretpassword"
    emailjs-service="service_xxx"
    emailjs-template="template_xxx"
    emailjs-key="user_xxx"
    theme="light"
    show-branding="true"
]
```

---

## 🎛️ Gutenberg Block

### Block Settings

| Setting | Description | Default |
|---------|-------------|---------|
| Event Name | Name of your event | Lade Stack Event |
| Event Date | Date (YYYY-MM-DD) | - |
| Event Time | Time (e.g., 7:00 PM) | - |
| Event Location | Venue address | - |
| Max Capacity | Maximum RSVPs | 50 |
| Fields | Comma-separated fields | name,email,phone,guests,dietary |
| Deadline | RSVP deadline (YYYY-MM-DD) | - |
| Approval Mode | Require admin approval | false |
| Admin Password | Dashboard password | ladestack123 |
| Theme | Light or Dark | light |
| Show Branding | Show Lade Stack footer | true |

---

## 📧 EmailJS Setup

### Step 1: Create Account
1. Go to [EmailJS.com](https://www.emailjs.com/)
2. Sign up for free account (200 emails/month free)

### Step 2: Add Email Service
1. Click **Add Service** → Select your provider (Gmail, Outlook, etc.)
2. Connect your account
3. Copy the **Service ID**

### Step 3: Create Email Template
1. Go to **Email Templates** → **Create New Template**
2. Use these variables in your template:

```
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

3. Copy the **Template ID**

### Step 4: Add Public Key
1. Go to **Account** → **API Keys**
2. Copy your **Public Key**

### Step 5: Add to Shortcode
```
[lade_rsvp_widget 
    emailjs-service="service_xxx"
    emailjs-template="template_xxx"
    emailjs-key="user_xxx"
]
```

---

## 🎨 Customization

### Themes

#### Light Theme (Default)
```
[lade_rsvp_widget theme="light"]
```

#### Dark Theme
```
[lade_rsvp_widget theme="dark"]
```

#### Auto (System Preference)
Automatically detects `prefers-color-scheme: dark`

### Field Toggles

Show only name and email:
```
[lade_rsvp_widget fields="name,email"]
```

All available fields:
```
[lade_rsvp_widget fields="name,email,phone,guests,dietary"]
```

### Position

```
[lade_rsvp_widget position="bottom-right"]
[lade_rsvp_widget position="bottom-left"]
[lade_rsvp_widget position="top-right"]
[lade_rsvp_widget position="top-left"]
```

---

## 🔐 Admin Dashboard

### Access Dashboard
1. Click the **⚙️ View RSVPs** button on widget header
2. Enter password (default: `ladestack123`)
3. View all RSVPs, approve/reject, export CSV

### Dashboard Features
- **Stats Row**: Total | Approved | Pending | Waitlist
- **Search**: Filter by name or email (live)
- **Status Filter**: All | Approved | Pending | Rejected
- **Actions**: 
  - 🎫 View/Download QR Code
  - ✓ Approve (sends email + downloads QR)
  - × Reject
  - 📋 Duplicate RSVP
- **Bulk Actions**: Approve All (approval mode only)
- **Export**: Export RSVPs CSV | Export Waitlist CSV

---

## ♿ Accessibility Features

### Keyboard Navigation
| Key | Action |
|-----|--------|
| `Tab` | Move between form fields |
| `Enter` | Submit form / Activate buttons |
| `Escape` | Close modals |
| `Space` | Activate buttons |

### Screen Reader Support
- ARIA labels on all interactive elements
- `role="alert"` for error messages
- `aria-live="polite"` for dynamic content
- `aria-required="true"` for required fields
- `aria-describedby` for field help text

### Focus Management
- Visible focus outlines (3px solid primary color)
- Focus trap in modals
- Skip link for keyboard users

### Motion Sensitivity
- Respects `prefers-reduced-motion: reduce`
- All animations disabled for reduced motion users

---

## 📱 Responsive Design

### Mobile (<480px)
- Full-width widget (90vw)
- Stacked form fields
- Larger touch targets (44px minimum)
- Horizontal scroll for admin table
- 16px font size (prevents iOS zoom)

### Tablet (481-768px)
- 90vw width
- 2-column stats grid
- Optimized header controls

### Desktop (>768px)
- Fixed 420px width
- Draggable and resizable
- Full admin panel features

---

## 💾 Data Storage

### localStorage Keys
- `lade_rsvp_{eventId}` - Main RSVP data
- `lade_rsvp_deadline_{eventId}` - Deadline state
- `lade_rsvp_widget_state` - Widget position/minimized state

### Data Structure
```json
{
  "rsvps": [
    {
      "id": "rsvp_1234567890_abc123",
      "name": "John Doe",
      "email": "john@example.com",
      "phone": "123-456-7890",
      "guests": 2,
      "dietary": ["Vegan", "Gluten-Free"],
      "status": "approved",
      "timestamp": "2026-03-09T10:30:00Z"
    }
  ],
  "waitlist": [],
  "approved": ["rsvp_1234567890_abc123"],
  "rejected": [],
  "settings": {
    "fields": ["name", "email", "phone", "guests", "dietary"],
    "capacity": 50
  }
}
```

### Export Data
Go to **WordPress Admin → Lade Stack RSVP** → Export All Data

---

## 🧪 Testing Checklist

### All Phases
- [ ] Drag widget around page
- [ ] Resize from corner
- [ ] Fill form and submit
- [ ] See capacity counter decrease
- [ ] Trigger low spots confetti
- [ ] Waitlist appears when full

### Email
- [ ] Set EmailJS credentials
- [ ] Submit RSVP
- [ ] Check console for "Email sent"
- [ ] See green "Confirmation sent!" toast
- [ ] Test error state (wrong keys) → red toast with retry

### Deadline
- [ ] Set near-future deadline
- [ ] See countdown in header pill
- [ ] Wait for deadline → form locks
- [ ] See "RSVP Closed" message

### Admin Dashboard
- [ ] Click "View RSVPs"
- [ ] Enter password `ladestack123`
- [ ] See stats row
- [ ] Search by name
- [ ] Filter by status
- [ ] Click QR button → modal opens
- [ ] Download QR
- [ ] Approve pending → QR auto-downloads
- [ ] Export RSVPs CSV
- [ ] Export Waitlist CSV

### Accessibility
- [ ] Tab through all fields
- [ ] Press Enter to submit
- [ ] Press Escape to close modal
- [ ] Test with screen reader
- [ ] Check focus outlines visible

### Mobile
- [ ] Test on iPhone/Android
- [ ] Touch drag widget
- [ ] Form fields stack vertically
- [ ] Touch targets 44px minimum
- [ ] No horizontal scroll

---

## ⚡ Performance

### CDN Dependencies (Lazy Loaded)
| Library | Size | Purpose |
|---------|------|---------|
| interact.js | 26KB | Drag & resize |
| EmailJS | 8KB | Email sending |
| QRCode.js | 4KB | QR generation |
| FileSaver.js | 6KB | CSV export |
| canvas-confetti | 5KB | Celebrations |

### Total Bundle Size
- **Gzipped:** <100KB
- **Uncompressed:** ~350KB

### Optimization Tips
1. Only loads CDNs on pages with widget
2. Async script loading
3. Minimal inline CSS
4. No database queries

---

## 🛠️ Troubleshooting

### Widget Not Appearing
1. Check shortcode syntax
2. Verify plugin is activated
3. Clear browser cache
4. Check browser console for errors

### Email Not Sending
1. Verify EmailJS credentials
2. Check Service ID, Template ID, Public Key
3. Ensure template variables match
4. Check EmailJS dashboard for errors

### QR Code Not Generating
1. Ensure QRCode.js CDN is loading
2. Check browser console
3. Test on HTTPS (some browsers block canvas on HTTP)

### Admin Dashboard Not Opening
1. Verify password (default: `ladestack123`)
2. Check for JavaScript errors
3. Clear localStorage: `localStorage.clear()`

### Data Lost on Refresh
- Data is stored in localStorage (persists across sessions)
- Clearing browser data will delete RSVPs
- Use Export CSV regularly for backup

---

## 📄 Shortcode Reference

| Attribute | Default | Description |
|-----------|---------|-------------|
| `event-name` | Lade Stack Event | Name of your event |
| `event-date` | - | Event date (YYYY-MM-DD) |
| `event-time` | - | Event time |
| `event-location` | - | Venue address |
| `max-capacity` | 50 | Maximum RSVPs |
| `waitlist-enabled` | true | Show waitlist when full |
| `fields` | name,email,phone,guests,dietary | Comma-separated fields |
| `deadline` | - | RSVP deadline (YYYY-MM-DD) |
| `approval-mode` | false | Require admin approval |
| `admin-password` | ladestack123 | Dashboard password |
| `emailjs-service` | - | EmailJS Service ID |
| `emailjs-template` | - | EmailJS Template ID |
| `emailjs-key` | - | EmailJS Public Key |
| `theme` | light | light or dark |
| `position` | bottom-right | Widget position |
| `show-branding` | true | Show Lade Stack footer |

---

## 🔗 Links

- **Demo:** [ladestack.in/rsvp-demo](https://ladestack.in)
- **Support:** [ladestack.in/support](https://ladestack.in)
- **EmailJS:** [emailjs.com](https://www.emailjs.com/)

---

## 📝 Changelog

### Version 1.0.0 (2026-03-09)
- ✅ Phase 1-2: Core widget with drag/resize
- ✅ Phase 3: Capacity management + waitlist
- ✅ Phase 4: EmailJS confirmation
- ✅ Phase 5: Deadline countdown
- ✅ Phase 6: Admin dashboard + CSV export
- ✅ Phase 7: QR codes + approval mode
- ✅ Phase 8: Production polish + a11y

---

## 📜 License

GPL v2 or later - [https://www.gnu.org/licenses/gpl-2.0.html](https://www.gnu.org/licenses/gpl-2.0.html)

---

**Made with ❤️ by Lade Stack** | [ladestack.in](https://ladestack.in)
