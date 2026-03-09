=== Lade Stack RSVP Widget ===
Contributors: ladestack
Donate link: https://ladestack.in/support
Tags: rsvp, event, registration, form, widget, event-management, guest-list
Requires at least: 5.0
Tested up to: 6.4
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Free AI-Powered RSVP Widget with Draggable Form, Live Counter, QR Codes, Email Confirmations, Admin Dashboard & CSV Export. No database required.

== Description ==

**Lade Stack RSVP Widget** is a free, AI-powered client-side RSVP management system for WordPress. Create beautiful, draggable RSVP forms with live capacity tracking, QR code generation, email confirmations, and a complete admin dashboard - all without using any database storage!

= KEY FEATURES =

**🎨 Beautiful Neumorphic Design**
- Modern, elegant interface that matches any website
- Light and dark theme support with auto-detection
- Fully customizable colors via CSS variables

**🖱️ Draggable & Resizable Widget**
- Drag the widget anywhere on your page
- Resize from corner for perfect fit
- Position: top-left, top-right, bottom-left, bottom-right

**📊 Live Capacity Management**
- Real-time spot counter with animations
- Low spots alerts (orange <10, red <5)
- Automatic waitlist when event is full
- Confetti celebration for last spots

**📧 Email Confirmations**
- EmailJS integration (free tier: 200 emails/month)
- Custom email templates with QR codes
- Success/error toast notifications
- Retry mechanism for failed sends

**⏰ Deadline System**
- Live countdown timer in header
- Auto-lock form at deadline
- Urgent alerts when <24 hours remaining
- Persistent storage across sessions

**🔐 Admin Dashboard**
- Password-protected access
- Complete RSVP management
- Search and filter by name/email/status
- Bulk approve/reject actions
- CSV export for RSVPs and waitlist

**🎫 QR Code Generation**
- Auto-generate unique QR codes
- Download individual QR codes
- Email QR codes to attendees
- Perfect for event check-in

**♿ Accessibility Ready**
- WCAG 2.1 AA compliant
- Full keyboard navigation
- Screen reader support with ARIA labels
- Reduced motion support

**🌍 Multi-Language Support**
- English and Marathi translations
- Easy to add more languages
- Translation-ready with POT file

**📱 Mobile Responsive**
- Touch-friendly interface
- Optimized for all screen sizes
- 44px minimum touch targets

= HOW IT WORKS =

1. **Install & Activate** - Upload plugin to WordPress
2. **Add Shortcode** - Use `[lade_rsvp_widget]` on any page
3. **Configure EmailJS** - Optional: Set up email confirmations
4. **Customize** - Adjust capacity, fields, deadline, colors
5. **Launch** - Start collecting RSVPs instantly!

= NO DATABASE REQUIRED =

All RSVP data is stored in browser localStorage, making this plugin:
- ⚡ Lightning fast (no database queries)
- 🔒 Privacy-friendly (data stays on user's device)
- 💾 Zero server storage costs
- 🚀 Scales to unlimited events

= PERFECT FOR =

- Weddings and receptions
- Corporate events
- Conferences and meetups
- Birthday parties
- Webinars and workshops
- Community gatherings
- Product launches
- Charity galas

= GUTENBERG BLOCK SUPPORT =

Fully compatible with WordPress Block Editor:
- Add RSVP widget as a block
- Configure settings visually
- Live preview in editor
- No shortcode needed!

= CUSTOMIZATION OPTIONS =

**Event Settings:**
- Event name, date, time, location
- RSVP deadline with countdown
- Maximum capacity
- Custom form fields

**Form Fields:**
- Name (required)
- Email (required)
- Phone number
- Number of guests
- Dietary preferences

**Styling:**
- Light/dark theme
- Custom CSS variables
- Brand colors
- Widget position

**Advanced:**
- Approval mode (require admin approval)
- Waitlist management
- Google Analytics tracking
- Multi-language support

= EMAILJS SETUP =

1. Sign up at [EmailJS.com](https://www.emailjs.com/) (free)
2. Add email service (Gmail, Outlook, etc.)
3. Create email template with variables: `{{name}}`, `{{email}}`, `{{event_name}}`
4. Copy Service ID, Template ID, Public Key to plugin settings

= SHORTCODE USAGE =

Basic:
`[lade_rsvp_widget event-name="My Event"]`

Full Configuration:
`[lade_rsvp_widget event-name="Annual Gala" event-date="2026-06-15" max-capacity="100" deadline="2026-06-10" approval-mode="true" admin-password="yourpassword" emailjs-service="service_xxx" emailjs-template="template_xxx" emailjs-key="user_xxx"]`

= CONTRIBUTING =

Found a bug or have a feature request?
- Report issues on [GitHub](https://github.com/girishlade111/WordPress-plugin-RSVP-Form)
- Submit pull requests
- Suggest translations

= SUPPORT & DOCUMENTATION =

- 📖 [Documentation](https://ladestack.in/docs)
- 🐛 [Bug Reports](https://github.com/girishlade111/WordPress-plugin-RSVP-Form/issues)
- 💬 [Support Forum](https://wordpress.org/support/plugin/lade-stack-rsvp)
- 🌐 [Website](https://ladestack.in)

= CREDITS =

Built with:
- [Interact.js](https://interactjs.io/) - Drag & resize
- [EmailJS](https://www.emailjs.com/) - Email delivery
- [QRCode.js](https://github.com/davidshimjs/qrcodejs) - QR generation
- [Canvas Confetti](https://github.com/catdad/canvas-confetti) - Celebrations

Developed by [Lade Stack](https://ladestack.in)

Released under GPL v2 or later.

== Installation ==

= Automatic Installation =

1. Log in to WordPress admin
2. Go to Plugins → Add New
3. Search for "Lade Stack RSVP"
4. Click "Install Now"
5. Click "Activate"

= Manual Installation =

1. Download the plugin ZIP file
2. Go to Plugins → Add New → Upload Plugin
3. Choose the ZIP file
4. Click "Install Now"
5. Click "Activate"

= FTP Installation =

1. Unzip the plugin folder
2. Upload to `/wp-content/plugins/` directory
3. Go to Plugins in WordPress admin
4. Click "Activate" on Lade Stack RSVP Widget

= After Activation =

1. Go to Settings → Lade Stack RSVP
2. Configure default settings (optional)
3. Add widget to any page using:
   - Gutenberg block: Add "Lade Stack RSVP" block
   - Shortcode: `[lade_rsvp_widget]`
4. Customize settings per widget

== Frequently Asked Questions ==

= Is this plugin really free? =

Yes! Lade Stack RSVP Widget is 100% free and open-source under GPL v2 or later. No hidden fees, no premium features locked behind paywalls.

= Does it require a database? =

No! All RSVP data is stored in browser localStorage. This means:
- No database tables created
- No server storage used
- Faster performance
- Better privacy

= What happens if user clears browser data? =

RSVP data is stored in browser localStorage. If user clears browser data, their RSVP data will be lost. We recommend:
1. Enable email confirmations (EmailJS)
2. Export CSV backups regularly
3. Use approval mode for important events

= Can I use multiple widgets on one page? =

Yes! Each widget has a unique ID based on event name. You can have unlimited RSVP widgets on a single page.

= Is EmailJS required? =

No, EmailJS is optional. Without it:
- RSVPs still work
- No email confirmations sent
- No QR codes emailed
- Admin dashboard still accessible

We highly recommend setting up EmailJS (free) for better user experience.

= How do I access the admin dashboard? =

1. Click the "⚙️ View RSVPs" button on widget header
2. Enter admin password (default: `ladestack123`)
3. View/manage all RSVPs

**Important:** Change default password in settings!

= Can I customize the colors? =

Yes! Use custom CSS variables:
`[lade_rsvp_widget custom-css='{"primary": "#ff6b6b", "success": "#48bb78"}']`

= Is my data secure? =

Yes! The plugin:
- Uses nonce verification
- Sanitizes all input
- Escapes all output
- No direct database access
- Client-side only (no server storage)

= Does it work with caching plugins? =

Yes! Since it's client-side only, it works perfectly with WP Rocket, W3 Total Cache, Autoptimize, etc.

= Can I export RSVP data? =

Yes! Admin dashboard includes:
- Export RSVPs to CSV
- Export Waitlist to CSV
- Export all data to JSON

= What browsers are supported? =

All modern browsers:
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+
- Mobile browsers (iOS Safari, Chrome Mobile)

= Can I translate to my language? =

Yes! The plugin is translation-ready with:
- POT template file included
- English and Marathi translations
- Easy to add more languages via WordPress translations

== Screenshots ==

1. Beautiful neumorphic RSVP widget with live capacity counter
2. Admin dashboard with stats, search, and CSV export
3. Mobile responsive design with touch-friendly interface
4. Gutenberg block editor with live preview
5. QR code generation and download
6. Deadline countdown with urgent alerts

== Changelog ==

= 1.0.0 - 2026-03-09 =

**Initial Release**

✨ **Phase 1-2: Core Widget**
- Draggable and resizable widget
- Neumorphic design system
- Light/dark theme support
- Mobile responsive layout
- Accessibility (WCAG 2.1 AA)

📊 **Phase 3: Capacity Management**
- Live capacity counter
- Low spots alerts
- Waitlist mode
- Confetti animations

📧 **Phase 4: Email Confirmations**
- EmailJS integration
- QR code in emails
- Success/error toasts
- Retry mechanism

⏰ **Phase 5: Deadline System**
- Live countdown timer
- Auto-lock at deadline
- Urgent alerts (<24h)
- Persistent storage

🔐 **Phase 6: Admin Dashboard**
- Password protection
- RSVP management
- Search and filter
- CSV export

🎫 **Phase 7: QR Codes + Approval**
- Auto-generate QR codes
- Approve/reject actions
- Email on approval
- Duplicate RSVPs

🎨 **Phase 8: Production Polish**
- Auto dark mode
- Full mobile responsive
- ARIA labels
- Loading spinners
- Lade Stack branding

🚀 **Phase 9: Pro Features**
- Custom CSS variables
- Multiple widgets per page
- Google Analytics events
- PWA support
- i18n (English/Marathi)

🔒 **Security Enhancements**
- XSS vulnerability fixes
- Null pointer protection
- localStorage quota handling
- Debounced operations
- Error boundaries

== Upgrade Notice ==

= 1.0.0 =

Initial release of Lade Stack RSVP Widget. No upgrade required.
