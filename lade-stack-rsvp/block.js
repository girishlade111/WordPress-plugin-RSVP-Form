/**
 * Lade Stack RSVP Widget - Gutenberg Block
 */

const { registerBlockType } = wp.blocks;
const { InspectorControls, BlockControls } = wp.blockEditor;
const { PanelBody, TextControl, TextareaControl, ToggleControl, SelectControl, ExternalLink } = wp.components;

registerBlockType('lade-stack/rsvp-widget', {
    title: 'Lade Stack RSVP Widget',
    icon: 'calendar-alt',
    category: 'widgets',
    description: 'Add a draggable RSVP widget with live capacity counter, QR codes, and admin dashboard.',
    keywords: ['rsvp', 'event', 'registration', 'form', 'calendar'],
    supports: {
        html: false,
        multiple: true,
    },
    attributes: {
        eventName: { type: 'string', default: 'Lade Stack Event' },
        eventDate: { type: 'string' },
        eventTime: { type: 'string' },
        eventLocation: { type: 'string' },
        maxCapacity: { type: 'number', default: 50 },
        fields: { type: 'string', default: 'name,email,phone,guests,dietary' },
        deadline: { type: 'string' },
        approvalMode: { type: 'boolean', default: false },
        adminPassword: { type: 'string', default: 'ladestack123' },
        emailjsService: { type: 'string' },
        emailjsTemplate: { type: 'string' },
        emailjsKey: { type: 'string' },
        theme: { type: 'string', default: 'light' },
        showBranding: { type: 'boolean', default: true },
    },
    edit: ({ attributes, setAttributes }) => {
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
        } = attributes;

        return (
            <>
                <BlockControls>
                    <div style={{ padding: '8px', background: '#f0f0f1', borderBottom: '1px solid #ddd' }}>
                        <strong>🎉 Lade Stack RSVP Widget</strong>
                    </div>
                </BlockControls>

                <InspectorControls>
                    <PanelBody title="Event Details" initialOpen={true}>
                        <TextControl
                            label="Event Name"
                            value={eventName}
                            onChange={(value) => setAttributes({ eventName: value })}
                            placeholder="My Awesome Event"
                        />
                        <TextControl
                            label="Event Date"
                            value={eventDate}
                            onChange={(value) => setAttributes({ eventDate: value })}
                            placeholder="2026-04-15"
                            help="Format: YYYY-MM-DD"
                        />
                        <TextControl
                            label="Event Time"
                            value={eventTime}
                            onChange={(value) => setAttributes({ eventTime: value })}
                            placeholder="7:00 PM"
                        />
                        <TextareaControl
                            label="Event Location"
                            value={eventLocation}
                            onChange={(value) => setAttributes({ eventLocation: value })}
                            placeholder="123 Main St, City"
                        />
                    </PanelBody>

                    <PanelBody title="RSVP Settings" initialOpen={false}>
                        <TextControl
                            label="Max Capacity"
                            type="number"
                            value={maxCapacity}
                            onChange={(value) => setAttributes({ maxCapacity: parseInt(value) || 50 })}
                            min="1"
                        />
                        <TextControl
                            label="RSVP Deadline"
                            value={deadline}
                            onChange={(value) => setAttributes({ deadline: value })}
                            placeholder="2026-04-10"
                            help="Format: YYYY-MM-DD"
                        />
                        <ToggleControl
                            label="Approval Mode"
                            help="Require admin approval before confirming RSVPs"
                            checked={approvalMode}
                            onChange={(value) => setAttributes({ approvalMode: value })}
                        />
                        {approvalMode && (
                            <TextControl
                                label="Admin Password"
                                value={adminPassword}
                                onChange={(value) => setAttributes({ adminPassword: value })}
                            />
                        )}
                    </PanelBody>

                    <PanelBody title="Form Fields" initialOpen={false}>
                        <TextControl
                            label="Fields (comma-separated)"
                            value={fields}
                            onChange={(value) => setAttributes({ fields: value })}
                            help="Available: name, email, phone, guests, dietary"
                        />
                    </PanelBody>

                    <PanelBody title="EmailJS Integration" initialOpen={false}>
                        <ExternalLink href="https://www.emailjs.com/">Get EmailJS Keys</ExternalLink>
                        <TextControl
                            label="Service ID"
                            value={emailjsService}
                            onChange={(value) => setAttributes({ emailjsService: value })}
                            placeholder="service_xxx"
                        />
                        <TextControl
                            label="Template ID"
                            value={emailjsTemplate}
                            onChange={(value) => setAttributes({ emailjsTemplate: value })}
                            placeholder="template_xxx"
                        />
                        <TextControl
                            label="Public Key"
                            value={emailjsKey}
                            onChange={(value) => setAttributes({ emailjsKey: value })}
                            placeholder="user_xxx"
                        />
                    </PanelBody>

                    <PanelBody title="Appearance" initialOpen={false}>
                        <SelectControl
                            label="Theme"
                            value={theme}
                            options={[
                                { label: 'Light', value: 'light' },
                                { label: 'Dark', value: 'dark' },
                            ]}
                            onChange={(value) => setAttributes({ theme: value })}
                        />
                        <ToggleControl
                            label="Show Lade Stack Branding"
                            checked={showBranding}
                            onChange={(value) => setAttributes({ showBranding: value })}
                        />
                    </PanelBody>
                </InspectorControls>

                <div style={{
                    padding: '40px 20px',
                    background: '#e0e5ec',
                    borderRadius: '12px',
                    textAlign: 'center',
                    border: '2px dashed #a3b1c6',
                }}>
                    <div style={{ fontSize: '48px', marginBottom: '10px' }}>🎉</div>
                    <h3 style={{ margin: '0 0 10px', color: '#2d3748' }}>{eventName}</h3>
                    <p style={{ color: '#4a5568', margin: '0 0 20px' }}>
                        RSVP Widget Preview
                    </p>
                    <div style={{
                        display: 'inline-block',
                        padding: '8px 16px',
                        background: '#667eea',
                        color: 'white',
                        borderRadius: '8px',
                        fontSize: '14px',
                    }}>
                        {maxCapacity} spots available
                    </div>
                    {approvalMode && (
                        <div style={{
                            marginTop: '10px',
                            padding: '6px 12px',
                            background: '#ed8936',
                            color: 'white',
                            borderRadius: '6px',
                            fontSize: '12px',
                            display: 'inline-block',
                        }}>
                            🔒 Approval Mode Enabled
                        </div>
                    )}
                    <p style={{ marginTop: '20px', fontSize: '12px', color: '#718096' }}>
                        Widget will appear here on the front end
                    </p>
                </div>
            </>
        );
    },
    save: () => {
        // Return null for dynamic blocks
        return null;
    },
});
