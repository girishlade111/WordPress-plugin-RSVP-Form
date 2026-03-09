# Changelog

All notable changes to Lade Stack RSVP Widget will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2026-03-09

### ✨ Added - Initial Release

#### Phase 1-2: Core Widget
- Draggable and resizable widget using Interact.js
- Neumorphic design system with light/dark themes
- Auto-detect system dark mode preference
- Fully mobile responsive layout
- Accessibility features (WCAG 2.1 AA compliant)
- Keyboard navigation support
- Screen reader compatibility with ARIA labels

#### Phase 3: Capacity Management
- Live capacity counter with real-time updates
- Low spots alerts (orange <10, red <5)
- Automatic waitlist mode when event is full
- Confetti animation for celebrations
- Spots remaining badge with pulsing animation

#### Phase 4: Email Confirmation
- EmailJS integration for email delivery
- Custom email templates with variables
- QR code generation and inclusion in emails
- Success toast notifications with shake animation
- Error toast with retry mechanism
- Loading spinners during email send

#### Phase 5: Deadline System
- Live countdown timer in widget header
- Auto-lock form when deadline passes
- Urgent alerts when <24 hours remaining
- Persistent deadline storage in localStorage
- "RSVP Closed" message after deadline

#### Phase 6: Admin Dashboard
- Password-protected admin access (default: ladestack123)
- Complete RSVP management dashboard
- Search functionality by name/email
- Filter by status (All/Approved/Pending/Rejected)
- Bulk approve all pending RSVPs
- CSV export for RSVPs and Waitlist
- Individual approve/reject actions
- QR code view and download

#### Phase 7: QR Codes + Approval
- Auto-generate unique QR codes on approval
- Download QR codes as PNG images
- Email QR codes to attendees
- Duplicate RSVP functionality
- Status badges (Pending/Approved/Rejected)
- Resend confirmation email on approve

#### Phase 8: Production Polish
- Auto dark mode via prefers-color-scheme
- Full mobile responsive with touch drag
- Enhanced ARIA labels throughout
- Loading spinners with SVG animation
- Lade Stack branding with logo
- Error boundaries and fallback handling
- Reduced motion support
- High contrast mode support
- 44px minimum touch targets

#### Phase 9: Pro Features
- Custom CSS variables for theming
- Multiple widgets per page support
- Google Analytics event tracking
- PWA support with manifest generation
- i18n support (English and Marathi)
- Language toggle button
- Analytics ID configuration
- Service worker for offline caching

### 🔒 Security
- Fixed XSS vulnerabilities in onclick handlers
- Added escapeHtml() with null protection
- Nonce verification for forms
- Input sanitization throughout
- Output escaping on all dynamic content
- localStorage quota exceeded handling
- Automatic cleanup of oldest storage entries
- Error boundaries for graceful degradation

### ⚡ Performance
- Lazy load CDNs with IntersectionObserver
- Conditional asset loading
- Debounced saveState operations (500ms)
- Debounced search input (300ms)
- Memory leak prevention
- Optimized event listener management

### 🛠️ Developer Experience
- WordPress i18n support with POT template
- Gutenberg block with full settings
- REST API endpoints for data export/clear
- Activation/deactivation/uninstall hooks
- JSDoc comments on public methods
- Comprehensive error logging
- DEBUG-REPORT.md documentation

### 📦 Infrastructure
- .gitignore for security
- .env.example template
- CREDENTIALS-TEMPLATE.md documentation
- uninstall.php for clean removal
- Languages directory with POT file
- Build script templates

### 🐛 Bug Fixes
- Fixed XSS in admin table onclick handlers (rsvp.id)
- Added null checks for DOM element access
- Fixed race conditions in async operations
- Fixed localStorage quota exceeded errors
- Fixed memory leaks in event listeners

---

## [Unreleased]

### Planned for Future Versions
- Multi-event dashboard
- Advanced analytics dashboard
- Custom email templates builder
- Webhook integrations (Zapier, Make)
- SMS notifications
- Payment integration (Stripe, PayPal)
- Recurring events support
- Custom form fields builder
- Advanced reporting and insights
- Multi-tenant SaaS dashboard

---

## Version History

| Version | Release Date | Status |
|---------|-------------|--------|
| 1.0.0 | 2026-03-09 | ✅ Released |

---

## Migration Guide

### From 1.0.0 to Future Versions

No migration required for version 1.0.0 as this is the initial release.

---

## Credits

### Contributors
- **Lade Stack** - Initial work and development

### Dependencies
- [Interact.js](https://interactjs.io/) - Drag & resize functionality
- [EmailJS](https://www.emailjs.com/) - Email delivery service
- [QRCode.js](https://github.com/davidshimjs/qrcodejs) - QR code generation
- [Canvas Confetti](https://github.com/catdad/canvas-confetti) - Celebration animations
- [FileSaver.js](https://github.com/eligrey/FileSaver.js) - File saving functionality

### Translators
- English: Default
- Marathi: Initial translation included

---

## Support

- **Documentation**: https://ladestack.in/docs
- **Bug Reports**: https://github.com/girishlade111/WordPress-plugin-RSVP-Form/issues
- **Support Forum**: https://wordpress.org/support/plugin/lade-stack-rsvp
- **Website**: https://ladestack.in

---

*For more information, visit the [plugin page](https://wordpress.org/plugins/lade-stack-rsvp/).*
