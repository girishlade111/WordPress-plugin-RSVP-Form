/**
 * Lade Stack RSVP Widget - Gutenberg Block
 * Production Ready with Pro Features
 */

const { registerBlockType } = wp.blocks;
const { InspectorControls, BlockControls, useBlockProps } = wp.blockEditor;
const { PanelBody, TextControl, TextareaControl, ToggleControl, SelectControl, ExternalLink, Notice } = wp.components;
const { __ } = wp.i18n;

registerBlockType('lade-stack/rsvp-widget', {
    title: __('Lade Stack RSVP Widget', 'lade-stack-rsvp'),
    icon: 'calendar-alt',
    category: 'widgets',
    description: __('Add a draggable RSVP widget with live capacity counter, QR codes, and admin dashboard.', 'lade-stack-rsvp'),
    keywords: [
        __('rsvp', 'lade-stack-rsvp'),
        __('event', 'lade-stack-rsvp'),
        __('registration', 'lade-stack-rsvp'),
        __('form', 'lade-stack-rsvp'),
        __('calendar', 'lade-stack-rsvp')
    ],
    supports: {
        html: false,
        multiple: true,
        align: ['left', 'right', 'center'],
    },
    attributes: {
        eventName: { type: 'string', default: 'Lade Stack Event' },
        eventDate: { type: 'string', default: '' },
        eventTime: { type: 'string', default: '' },
        eventLocation: { type: 'string', default: '' },
        maxCapacity: { type: 'number', default: 50 },
        fields: { type: 'string', default: 'name,email,phone,guests,dietary' },
        deadline: { type: 'string', default: '' },
        approvalMode: { type: 'boolean', default: false },
        adminPassword: { type: 'string', default: 'ladestack123' },
        emailjsService: { type: 'string', default: '' },
        emailjsTemplate: { type: 'string', default: '' },
        emailjsKey: { type: 'string', default: '' },
        theme: { type: 'string', default: 'light' },
        showBranding: { type: 'boolean', default: true },
        // Pro Features (Phase 9)
        language: { type: 'string', default: 'en' },
        analyticsId: { type: 'string', default: '' },
        customCSS: { type: 'string', default: '' },
    },
    edit: ({ attributes, setAttributes }) => {
        const blockProps = useBlockProps({
            className: 'lade-stack-rsvp-block'
        });

        const {
            eventName,
            eventDate,
            eventTime,
            eventLocation,
            maxCapacity,
            fields,
            deadline,
            approvalMode,
            adminPassword,
            emailjsService,
            emailjsTemplate,
            emailjsKey,
            theme,
            showBranding,
            language,
            analyticsId,
            customCSS,
        } = attributes;

        // Language options
        const languageOptions = [
            { label: '🇬🇧 ' + __('English', 'lade-stack-rsvp'), value: 'en' },
            { label: '🇮🇳 ' + __('Marathi', 'lade-stack-rsvp'), value: 'mr' },
        ];

        return (
            <div {...blockProps}>
                <BlockControls>
                    <div style={{ 
                        padding: '8px 12px', 
                        background: '#667eea', 
                        color: 'white',
                        borderBottom: '1px solid #5a6fd6',
                        fontWeight: '600',
                        fontSize: '13px'
                    }}>
                        🎉 {__('Lade Stack RSVP Widget', 'lade-stack-rsvp')}
                    </div>
                </BlockControls>

                <InspectorControls>
                    <PanelBody title={__('📅 Event Details', 'lade-stack-rsvp')} initialOpen={true}>
                        <TextControl
                            label={__('Event Name', 'lade-stack-rsvp')}
                            value={eventName}
                            onChange={(value) => setAttributes({ eventName: value })}
                            placeholder={__('My Awesome Event', 'lade-stack-rsvp')}
                            required
                        />
                        <TextControl
                            label={__('Event Date', 'lade-stack-rsvp')}
                            value={eventDate}
                            onChange={(value) => setAttributes({ eventDate: value })}
                            placeholder="2026-04-15"
                            help={__('Format: YYYY-MM-DD', 'lade-stack-rsvp')}
                        />
                        <TextControl
                            label={__('Event Time', 'lade-stack-rsvp')}
                            value={eventTime}
                            onChange={(value) => setAttributes({ eventTime: value })}
                            placeholder="7:00 PM"
                        />
                        <TextareaControl
                            label={__('Event Location', 'lade-stack-rsvp')}
                            value={eventLocation}
                            onChange={(value) => setAttributes({ eventLocation: value })}
                            placeholder="123 Main St, City, Country"
                        />
                    </PanelBody>

                    <PanelBody title={__('🎫 RSVP Settings', 'lade-stack-rsvp')} initialOpen={false}>
                        <TextControl
                            label={__('Max Capacity', 'lade-stack-rsvp')}
                            type="number"
                            value={maxCapacity}
                            onChange={(value) => setAttributes({ maxCapacity: parseInt(value) || 50 })}
                            min="1"
                            max="10000"
                        />
                        <TextControl
                            label={__('RSVP Deadline', 'lade-stack-rsvp')}
                            value={deadline}
                            onChange={(value) => setAttributes({ deadline: value })}
                            placeholder="2026-04-10"
                            help={__('Format: YYYY-MM-DD', 'lade-stack-rsvp')}
                        />
                        <ToggleControl
                            label={__('Approval Mode', 'lade-stack-rsvp')}
                            help={__('Require admin approval before confirming RSVPs', 'lade-stack-rsvp')}
                            checked={approvalMode}
                            onChange={(value) => setAttributes({ approvalMode: value })}
                        />
                        {approvalMode && (
                            <TextControl
                                label={__('Admin Password', 'lade-stack-rsvp')}
                                value={adminPassword}
                                onChange={(value) => setAttributes({ adminPassword: value })}
                                type="password"
                            />
                        )}
                    </PanelBody>

                    <PanelBody title={__('📝 Form Fields', 'lade-stack-rsvp')} initialOpen={false}>
                        <TextControl
                            label={__('Fields (comma-separated)', 'lade-stack-rsvp')}
                            value={fields}
                            onChange={(value) => setAttributes({ fields: value })}
                            help={__('Available: name, email, phone, guests, dietary', 'lade-stack-rsvp')}
                        />
                    </PanelBody>

                    <PanelBody title={__('📧 EmailJS Integration', 'lade-stack-rsvp')} initialOpen={false}>
                        <Notice status="info" isDismissible={false}>
                            <a href="https://www.emailjs.com/" target="_blank" rel="noopener noreferrer">
                                {__('Get EmailJS Keys (Free)', 'lade-stack-rsvp')} →
                            </a>
                        </Notice>
                        <TextControl
                            label={__('Service ID', 'lade-stack-rsvp')}
                            value={emailjsService}
                            onChange={(value) => setAttributes({ emailjsService: value })}
                            placeholder="service_xxx"
                        />
                        <TextControl
                            label={__('Template ID', 'lade-stack-rsvp')}
                            value={emailjsTemplate}
                            onChange={(value) => setAttributes({ emailjsTemplate: value })}
                            placeholder="template_xxx"
                        />
                        <TextControl
                            label={__('Public Key', 'lade-stack-rsvp')}
                            value={emailjsKey}
                            onChange={(value) => setAttributes({ emailjsKey: value })}
                            placeholder="user_xxx"
                            type="password"
                        />
                    </PanelBody>

                    <PanelBody title={__('🌐 Pro Features', 'lade-stack-rsvp')} initialOpen={false}>
                        <SelectControl
                            label={__('Language', 'lade-stack-rsvp')}
                            value={language}
                            options={languageOptions}
                            onChange={(value) => setAttributes({ language: value })}
                            help={__('Widget language (English/Marathi)', 'lade-stack-rsvp')}
                        />
                        <TextControl
                            label={__('Google Analytics ID', 'lade-stack-rsvp')}
                            value={analyticsId}
                            onChange={(value) => setAttributes({ analyticsId: value })}
                            placeholder="G-XXXXXXXXXX"
                            help={__('Track RSVP submissions in Analytics', 'lade-stack-rsvp')}
                        />
                        <TextareaControl
                            label={__('Custom CSS Variables', 'lade-stack-rsvp')}
                            value={customCSS}
                            onChange={(value) => setAttributes({ customCSS: value })}
                            placeholder='{"primary": "#ff6b6b", "width": "500px"}'
                            help={__('JSON format CSS variables for custom theming', 'lade-stack-rsvp')}
                        />
                    </PanelBody>

                    <PanelBody title={__('🎨 Appearance', 'lade-stack-rsvp')} initialOpen={false}>
                        <SelectControl
                            label={__('Theme', 'lade-stack-rsvp')}
                            value={theme}
                            options={[
                                { label: __('☀️ Light', 'lade-stack-rsvp'), value: 'light' },
                                { label: __('🌙 Dark', 'lade-stack-rsvp'), value: 'dark' },
                            ]}
                            onChange={(value) => setAttributes({ theme: value })}
                        />
                        <ToggleControl
                            label={__('Show Lade Stack Branding', 'lade-stack-rsvp')}
                            checked={showBranding}
                            onChange={(value) => setAttributes({ showBranding: value })}
                            help={__('Display "Powered by Lade Stack" footer', 'lade-stack-rsvp')}
                        />
                    </PanelBody>
                </InspectorControls>

                <div style={{
                    padding: '60px 30px',
                    background: 'linear-gradient(135deg, #e0e5ec 0%, #e8eef5 100%)',
                    borderRadius: '20px',
                    textAlign: 'center',
                    border: '3px dashed #a3b1c6',
                    boxShadow: 'inset 6px 6px 12px rgba(163, 177, 198, 0.3), inset -6px -6px 12px rgba(255, 255, 255, 0.9)',
                }}>
                    <div style={{ fontSize: '64px', marginBottom: '16px' }}>🎉</div>
                    <h3 style={{ 
                        margin: '0 0 12px', 
                        color: '#2d3748',
                        fontSize: '20px',
                        fontWeight: '700'
                    }}>
                        {eventName}
                    </h3>
                    <p style={{ 
                        color: '#4a5568', 
                        margin: '0 0 24px',
                        fontSize: '14px'
                    }}>
                        {__('RSVP Widget Preview', 'lade-stack-rsvp')}
                    </p>
                    <div style={{
                        display: 'inline-flex',
                        alignItems: 'center',
                        gap: '8px',
                        padding: '10px 20px',
                        background: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                        color: 'white',
                        borderRadius: '25px',
                        fontSize: '14px',
                        fontWeight: '600',
                        boxShadow: '4px 4px 8px rgba(102, 126, 234, 0.4)',
                    }}>
                        <span style={{ width: '8px', height: '8px', background: '#48bb78', borderRadius: '50%', display: 'inline-block' }}></span>
                        {maxCapacity} {__('spots available', 'lade-stack-rsvp')}
                    </div>
                    {approvalMode && (
                        <div style={{
                            marginTop: '16px',
                            display: 'inline-block',
                            padding: '8px 16px',
                            background: 'linear-gradient(135deg, #ed8936 0%, #f56565 100%)',
                            color: 'white',
                            borderRadius: '20px',
                            fontSize: '12px',
                            fontWeight: '600',
                        }}>
                            🔒 {__('Approval Mode Enabled', 'lade-stack-rsvp')}
                        </div>
                    )}
                    {language === 'mr' && (
                        <div style={{
                            marginTop: '16px',
                            fontSize: '14px',
                            color: '#667eea',
                            fontWeight: '600'
                        }}>
                            🇮🇳 {__('मराठी भाषा सक्षम', 'lade-stack-rsvp')}
                        </div>
                    )}
                    <p style={{ 
                        marginTop: '32px', 
                        fontSize: '12px', 
                        color: '#718096',
                        fontStyle: 'italic'
                    }}>
                        {__('Widget will appear here on the front end', 'lade-stack-rsvp')}
                    </p>
                </div>
            </div>
        );
    },
    save: () => {
        // Return null for dynamic blocks (server-side rendered)
        return null;
    },
});
