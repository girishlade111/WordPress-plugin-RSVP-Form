<?php
/**
 * Widget Script and Styles
 * This file contains the complete client-side widget implementation
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}
?>

<style>
/* ============================================
   LADE STACK RSVP WIDGET - COMPLETE CSS
   Neumorphic Design System
   ============================================ */

:root {
    /* Light Theme Colors */
    --lade-bg-primary: #e0e5ec;
    --lade-bg-secondary: #e8eef5;
    --lade-shadow-light: #ffffff;
    --lade-shadow-dark: #a3b1c6;
    --lade-shadow-dark-strong: #8a9ab0;
    
    /* Accent Colors */
    --lade-primary: #667eea;
    --lade-primary-hover: #5a6fd6;
    --lade-primary-light: #7c8ef0;
    --lade-success: #48bb78;
    --lade-success-hover: #38a169;
    --lade-warning: #ed8936;
    --lade-danger: #f56565;
    --lade-danger-hover: #e53e3e;
    --lade-info: #4299e1;
    
    /* Text Colors */
    --lade-text-primary: #2d3748;
    --lade-text-secondary: #4a5568;
    --lade-text-muted: #718096;
    --lade-text-light: #a0aec0;
    
    /* Status Colors */
    --lade-pending: #ed8936;
    --lade-approved: #48bb78;
    --lade-rejected: #f56565;
    
    /* Sizing */
    --lade-widget-width: 420px;
    --lade-widget-height: 600px;
    --lade-widget-min-width: 340px;
    --lade-widget-min-height: 450px;
    --lade-border-radius: 20px;
    --lade-border-radius-sm: 12px;
    --lade-border-radius-xs: 8px;
    
    /* Transitions */
    --lade-transition-fast: 0.15s ease;
    --lade-transition-normal: 0.3s ease;
    --lade-transition-slow: 0.5s ease;
}

/* Dark Theme */
[data-theme="dark"] {
    --lade-bg-primary: #1a202c;
    --lade-bg-secondary: #2d3748;
    --lade-shadow-light: #2d3748;
    --lade-shadow-dark: #0f141c;
    --lade-shadow-dark-strong: #0a0f16;
    --lade-text-primary: #f7fafc;
    --lade-text-secondary: #e2e8f0;
    --lade-text-muted: #a0aec0;
    --lade-text-light: #718096;
}

/* Reset & Base */
#lade-rsvp-widget-container * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

#lade-rsvp-widget-container {
    font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, Oxygen, Ubuntu, sans-serif;
    line-height: 1.5;
    color: var(--lade-text-primary);
}

/* Widget Container */
.lade-widget {
    position: fixed;
    width: var(--lade-widget-width);
    height: var(--lade-widget-height);
    min-width: var(--lade-widget-min-width);
    min-height: var(--lade-widget-min-height);
    max-width: 90vw;
    max-height: 90vh;
    background: var(--lade-bg-primary);
    border-radius: var(--lade-border-radius);
    box-shadow: 
        12px 12px 24px var(--lade-shadow-dark),
        -12px -12px 24px var(--lade-shadow-light);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    z-index: 999999;
    transition: all var(--lade-transition-normal);
}

.lade-widget.minimized {
    height: 64px;
}

.lade-widget.minimized .lade-widget-body {
    display: none;
}

.lade-widget.hidden {
    display: none;
}

/* Drag Handle / Header */
.lade-widget-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    background: var(--lade-bg-primary);
    border-bottom: 1px solid rgba(163, 177, 198, 0.2);
    cursor: grab;
    user-select: none;
    flex-shrink: 0;
}

.lade-widget-header:active {
    cursor: grabbing;
}

.lade-widget-header.dragging {
    opacity: 0.8;
}

.lade-header-left {
    display: flex;
    align-items: center;
    gap: 10px;
}

.lade-drag-icon {
    font-size: 18px;
    color: var(--lade-text-muted);
    cursor: grab;
}

.lade-widget-title {
    font-size: 15px;
    font-weight: 600;
    color: var(--lade-text-primary);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 200px;
}

.lade-widget-controls {
    display: flex;
    gap: 8px;
}

.lade-control-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: none;
    background: var(--lade-bg-primary);
    box-shadow: 
        3px 3px 6px var(--lade-shadow-dark),
        -3px -3px 6px var(--lade-shadow-light);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    color: var(--lade-text-secondary);
    transition: all var(--lade-transition-fast);
}

/* Settings Gear Button */
.lade-settings-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: none;
    background: var(--lade-bg-primary);
    box-shadow: 
        3px 3px 6px var(--lade-shadow-dark),
        -3px -3px 6px var(--lade-shadow-light);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    color: var(--lade-text-secondary);
    transition: all var(--lade-transition-fast);
    margin-right: 8px;
}

.lade-settings-btn:hover {
    box-shadow: 
        inset 3px 3px 6px var(--lade-shadow-dark),
        inset -3px -3px 6px var(--lade-shadow-light);
    color: var(--lade-primary);
    transform: rotate(30deg);
}

.lade-control-btn:hover {
    box-shadow: 
        inset 3px 3px 6px var(--lade-shadow-dark),
        inset -3px -3px 6px var(--lade-shadow-light);
    color: var(--lade-primary);
}

.lade-control-btn.close:hover {
    background: var(--lade-danger);
    color: white;
    box-shadow: 
        3px 3px 6px rgba(245, 101, 101, 0.4),
        -3px -3px 6px rgba(255, 255, 255, 0.1);
}

/* Widget Body */
.lade-widget-body {
    flex: 1;
    padding: 20px;
    overflow-y: auto;
    overflow-x: hidden;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.lade-widget-body::-webkit-scrollbar {
    width: 6px;
}

.lade-widget-body::-webkit-scrollbar-track {
    background: var(--lade-bg-primary);
    border-radius: 3px;
}

.lade-widget-body::-webkit-scrollbar-thumb {
    background: var(--lade-shadow-dark);
    border-radius: 3px;
}

/* Event Info Card */
.lade-event-card {
    padding: 16px;
    border-radius: var(--lade-border-radius-sm);
    background: var(--lade-bg-primary);
    box-shadow: 
        inset 4px 4px 8px var(--lade-shadow-dark),
        inset -4px -4px 8px var(--lade-shadow-light);
    text-align: center;
}

.lade-event-name {
    font-size: 17px;
    font-weight: 700;
    color: var(--lade-text-primary);
    margin-bottom: 8px;
}

.lade-event-details {
    display: flex;
    flex-direction: column;
    gap: 4px;
    font-size: 13px;
    color: var(--lade-text-muted);
}

.lade-event-detail {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}

.lade-event-detail svg {
    width: 14px;
    height: 14px;
    fill: var(--lade-text-muted);
}

/* Spots Counter Badge */
.lade-spots-container {
    text-align: center;
}

.lade-spots-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 25px;
    background: var(--lade-bg-primary);
    box-shadow: 
        4px 4px 8px var(--lade-shadow-dark),
        -4px -4px 8px var(--lade-shadow-light);
    font-size: 14px;
    font-weight: 600;
    color: var(--lade-success);
    transition: all var(--lade-transition-normal);
}

.lade-spots-badge.low-spots {
    color: var(--lade-warning);
}

.lade-spots-badge.critical-spots {
    color: var(--lade-danger);
    animation: ladePulse 1s infinite;
}

.lade-spots-badge.full {
    color: var(--lade-text-muted);
    background: var(--lade-shadow-dark);
}

.lade-spots-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: currentColor;
    animation: ladePulse 2s infinite;
}

@keyframes ladePulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(0.9); }
}

/* Confetti Animation for Low Spots */
@keyframes ladeConfetti {
    0% { transform: translateY(0) rotate(0deg); opacity: 1; }
    100% { transform: translateY(-100px) rotate(360deg); opacity: 0; }
}

.lade-confetti {
    position: absolute;
    width: 8px;
    height: 8px;
    background: var(--lade-success);
    animation: ladeConfetti 1s ease-out forwards;
}

/* Form Styles */
.lade-form {
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.lade-form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.lade-form-group.hidden {
    display: none;
}

.lade-form-label {
    font-size: 13px;
    font-weight: 600;
    color: var(--lade-text-secondary);
    margin-left: 4px;
    display: flex;
    align-items: center;
    gap: 4px;
}

.lade-required {
    color: var(--lade-danger);
}

.lade-form-input,
.lade-form-select {
    width: 100%;
    padding: 14px 16px;
    border: none;
    border-radius: var(--lade-border-radius-sm);
    background: var(--lade-bg-primary);
    box-shadow: 
        inset 4px 4px 8px var(--lade-shadow-dark),
        inset -4px -4px 8px var(--lade-shadow-light);
    font-size: 14px;
    color: var(--lade-text-primary);
    outline: none;
    transition: all var(--lade-transition-fast);
    font-family: inherit;
}

.lade-form-input::placeholder {
    color: var(--lade-text-light);
}

.lade-form-input:focus,
.lade-form-select:focus {
    box-shadow: 
        inset 6px 6px 12px var(--lade-shadow-dark-strong),
        inset -6px -6px 12px var(--lade-shadow-light);
}

.lade-form-input.error {
    box-shadow: 
        inset 4px 4px 8px rgba(245, 101, 101, 0.2),
        inset -4px -4px 8px rgba(255, 255, 255, 0.1);
    border: 1px solid var(--lade-danger);
}

.lade-form-error {
    font-size: 12px;
    color: var(--lade-danger);
    margin-left: 4px;
    display: none;
}

.lade-form-error.visible {
    display: block;
}

/* Dietary Preferences Checkboxes */
.lade-dietary-options {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 8px;
    padding: 8px;
    border-radius: var(--lade-border-radius-sm);
    background: var(--lade-bg-primary);
    box-shadow: 
        inset 4px 4px 8px var(--lade-shadow-dark),
        inset -4px -4px 8px var(--lade-shadow-light);
}

.lade-dietary-option {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px;
    border-radius: var(--lade-border-radius-xs);
    cursor: pointer;
    transition: all var(--lade-transition-fast);
}

.lade-dietary-option:hover {
    background: var(--lade-bg-secondary);
}

.lade-dietary-option input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: var(--lade-primary);
    cursor: pointer;
}

.lade-dietary-option label {
    font-size: 13px;
    color: var(--lade-text-secondary);
    cursor: pointer;
    flex: 1;
}

/* Submit Button */
.lade-submit-btn {
    width: 100%;
    padding: 16px;
    border: none;
    border-radius: var(--lade-border-radius-sm);
    background: linear-gradient(135deg, var(--lade-primary) 0%, var(--lade-primary-light) 100%);
    color: white;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all var(--lade-transition-normal);
    box-shadow: 
        4px 4px 8px rgba(102, 126, 234, 0.4),
        -4px -4px 8px rgba(255, 255, 255, 0.3);
    position: relative;
    overflow: hidden;
}

.lade-submit-btn:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 
        6px 6px 12px rgba(102, 126, 234, 0.5),
        -6px -6px 12px rgba(255, 255, 255, 0.4);
}

.lade-submit-btn:active:not(:disabled) {
    transform: translateY(0);
    box-shadow: 
        inset 4px 4px 8px rgba(0, 0, 0, 0.2),
        inset -4px -4px 8px rgba(255, 255, 255, 0.1);
}

.lade-submit-btn:disabled {
    cursor: not-allowed;
    opacity: 0.5;
    background: var(--lade-text-muted);
}

.lade-submit-btn.loading {
    pointer-events: none;
}

.lade-submit-btn.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-top-color: white;
    border-radius: 50%;
    animation: ladeSpin 0.8s linear infinite;
}

@keyframes ladeSpin {
    to { transform: rotate(360deg); }
}

/* Waitlist Form */
.lade-waitlist-notice {
    text-align: center;
    padding: 20px;
    border-radius: var(--lade-border-radius-sm);
    background: var(--lade-bg-primary);
    box-shadow: 
        inset 4px 4px 8px var(--lade-shadow-dark),
        inset -4px -4px 8px var(--lade-shadow-light);
}

.lade-waitlist-notice h4 {
    font-size: 16px;
    color: var(--lade-warning);
    margin-bottom: 8px;
}

.lade-waitlist-notice p {
    font-size: 13px;
    color: var(--lade-text-muted);
    margin-bottom: 16px;
}

/* Deadline Countdown */
.lade-deadline-countdown {
    display: flex;
    justify-content: center;
    gap: 12px;
    padding: 16px;
    border-radius: var(--lade-border-radius-sm);
    background: var(--lade-bg-primary);
    box-shadow: 
        inset 4px 4px 8px var(--lade-shadow-dark),
        inset -4px -4px 8px var(--lade-shadow-light);
}

.lade-countdown-item {
    text-align: center;
}

.lade-countdown-value {
    font-size: 24px;
    font-weight: 700;
    color: var(--lade-primary);
    display: block;
}

.lade-countdown-label {
    font-size: 11px;
    color: var(--lade-text-muted);
    text-transform: uppercase;
}

.lade-deadline-expired {
    text-align: center;
    padding: 30px;
    color: var(--lade-danger);
}

.lade-deadline-expired h4 {
    font-size: 18px;
    margin-bottom: 8px;
}

.lade-deadline-expired p {
    font-size: 14px;
    color: var(--lade-text-muted);
}

/* Success Message */
.lade-success-message {
    text-align: center;
    padding: 30px 20px;
}

.lade-success-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 20px;
    border-radius: 50%;
    background: var(--lade-success);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 
        8px 8px 16px rgba(72, 187, 120, 0.4),
        -8px -8px 16px rgba(255, 255, 255, 0.3);
    animation: ladeSuccessPop 0.5s ease;
}

@keyframes ladeSuccessPop {
    0% { transform: scale(0); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

.lade-success-icon svg {
    width: 40px;
    height: 40px;
    fill: white;
}

.lade-success-message h3 {
    font-size: 20px;
    color: var(--lade-text-primary);
    margin-bottom: 8px;
}

.lade-success-message p {
    font-size: 14px;
    color: var(--lade-text-muted);
    margin-bottom: 20px;
}

.lade-qr-container {
    margin: 20px 0;
    padding: 16px;
    border-radius: var(--lade-border-radius-sm);
    background: var(--lade-bg-primary);
    box-shadow: 
        inset 4px 4px 8px var(--lade-shadow-dark),
        inset -4px -4px 8px var(--lade-shadow-light);
}

.lade-qr-container canvas {
    margin: 0 auto;
    display: block;
}

.lade-qr-download {
    margin-top: 12px;
    padding: 10px 20px;
    border: none;
    border-radius: var(--lade-border-radius-xs);
    background: var(--lade-primary);
    color: white;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all var(--lade-transition-fast);
}

.lade-qr-download:hover {
    background: var(--lade-primary-hover);
    transform: translateY(-1px);
}

/* Admin Dashboard Tab */
.lade-admin-tab {
    position: absolute;
    top: 10px;
    left: 10px;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: none;
    background: var(--lade-bg-primary);
    box-shadow: 
        3px 3px 6px var(--lade-shadow-dark),
        -3px -3px 6px var(--lade-shadow-light);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    color: var(--lade-text-secondary);
    transition: all var(--lade-transition-fast);
    z-index: 10;
}

.lade-admin-tab:hover {
    box-shadow: 
        inset 3px 3px 6px var(--lade-shadow-dark),
        inset -3px -3px 6px var(--lade-shadow-light);
    color: var(--lade-primary);
}

/* Admin Dashboard Panel */
.lade-admin-panel {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0.9);
    width: 90vw;
    max-width: 800px;
    max-height: 80vh;
    background: var(--lade-bg-primary);
    border-radius: var(--lade-border-radius);
    box-shadow: 
        24px 24px 48px var(--lade-shadow-dark),
        -24px -24px 48px var(--lade-shadow-light);
    z-index: 1000000;
    opacity: 0;
    visibility: hidden;
    transition: all var(--lade-transition-normal);
    overflow: hidden;
}

.lade-admin-panel.active {
    opacity: 1;
    visibility: visible;
    transform: translate(-50%, -50%) scale(1);
}

.lade-admin-panel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border-bottom: 1px solid rgba(163, 177, 198, 0.2);
}

.lade-admin-panel-header h3 {
    font-size: 18px;
    color: var(--lade-text-primary);
}

.lade-admin-panel-close {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: none;
    background: var(--lade-bg-primary);
    box-shadow: 
        3px 3px 6px var(--lade-shadow-dark),
        -3px -3px 6px var(--lade-shadow-light);
    cursor: pointer;
    font-size: 18px;
    color: var(--lade-text-secondary);
    transition: all var(--lade-transition-fast);
}

.lade-admin-panel-close:hover {
    box-shadow: 
        inset 3px 3px 6px var(--lade-shadow-dark),
        inset -3px -3px 6px var(--lade-shadow-light);
    color: var(--lade-danger);
}

.lade-admin-panel-body {
    padding: 20px;
    overflow-y: auto;
    max-height: calc(80vh - 140px);
}

/* Password Modal */
.lade-password-modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000001;
    opacity: 0;
    visibility: hidden;
    transition: all var(--lade-transition-normal);
}

.lade-password-modal.active {
    opacity: 1;
    visibility: visible;
}

.lade-password-box {
    padding: 30px;
    background: var(--lade-bg-primary);
    border-radius: var(--lade-border-radius);
    box-shadow: 
        24px 24px 48px var(--lade-shadow-dark),
        -24px -24px 48px var(--lade-shadow-light);
    text-align: center;
    max-width: 400px;
    width: 90%;
}

.lade-password-box h4 {
    font-size: 18px;
    color: var(--lade-text-primary);
    margin-bottom: 20px;
}

.lade-password-input {
    width: 100%;
    padding: 14px 16px;
    border: none;
    border-radius: var(--lade-border-radius-sm);
    background: var(--lade-bg-primary);
    box-shadow: 
        inset 4px 4px 8px var(--lade-shadow-dark),
        inset -4px -4px 8px var(--lade-shadow-light);
    font-size: 14px;
    color: var(--lade-text-primary);
    outline: none;
    margin-bottom: 16px;
    text-align: center;
}

.lade-password-btn {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: var(--lade-border-radius-sm);
    background: var(--lade-primary);
    color: white;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all var(--lade-transition-fast);
}

.lade-password-btn:hover {
    background: var(--lade-primary-hover);
    transform: translateY(-1px);
}

/* Field Toggle Modal */
.lade-field-modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000002;
    opacity: 0;
    visibility: hidden;
    transition: all var(--lade-transition-normal);
}

.lade-field-modal.active {
    opacity: 1;
    visibility: visible;
}

.lade-field-box {
    padding: 30px;
    background: var(--lade-bg-primary);
    border-radius: var(--lade-border-radius);
    box-shadow: 
        24px 24px 48px var(--lade-shadow-dark),
        -24px -24px 48px var(--lade-shadow-light);
    max-width: 400px;
    width: 90%;
}

.lade-field-box h4 {
    font-size: 18px;
    color: var(--lade-text-primary);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.lade-field-options {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 20px;
}

.lade-field-option {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 16px;
    background: var(--lade-bg-primary);
    border-radius: var(--lade-border-radius-sm);
    box-shadow: 
        inset 3px 3px 6px var(--lade-shadow-dark),
        inset -3px -3px 6px var(--lade-shadow-light);
    cursor: pointer;
    transition: all var(--lade-transition-fast);
}

.lade-field-option:hover {
    box-shadow: 
        inset 5px 5px 10px var(--lade-shadow-dark),
        inset -5px -5px 10px var(--lade-shadow-light);
}

.lade-field-option label {
    flex: 1;
    font-size: 14px;
    color: var(--lade-text-secondary);
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 10px;
}

.lade-field-option input[type="checkbox"] {
    width: 20px;
    height: 20px;
    accent-color: var(--lade-primary);
    cursor: pointer;
}

.lade-field-option .field-icon {
    font-size: 18px;
}

.lade-field-actions {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

.lade-field-btn {
    padding: 10px 20px;
    border: none;
    border-radius: var(--lade-border-radius-xs);
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all var(--lade-transition-fast);
}

.lade-field-btn.primary {
    background: var(--lade-primary);
    color: white;
}

.lade-field-btn.primary:hover {
    background: var(--lade-primary-hover);
    transform: translateY(-1px);
}

.lade-field-btn.secondary {
    background: var(--lade-bg-primary);
    color: var(--lade-text-secondary);
    box-shadow: 
        3px 3px 6px var(--lade-shadow-dark),
        -3px -3px 6px var(--lade-shadow-light);
}

.lade-field-btn.secondary:hover {
    box-shadow: 
        inset 3px 3px 6px var(--lade-shadow-dark),
        inset -3px -3px 6px var(--lade-shadow-light);
}

/* Shake Animation */
@keyframes ladeShake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-8px); }
    20%, 40%, 60%, 80% { transform: translateX(8px); }
}

.lade-shake {
    animation: ladeShake 0.5s ease-in-out;
}

/* Validation Error States */
.lade-form-input.error {
    border: 2px solid var(--lade-danger);
    box-shadow: 
        inset 3px 3px 6px rgba(245, 101, 101, 0.2),
        inset -3px -3px 6px rgba(255, 255, 255, 0.1),
        0 0 0 3px rgba(245, 101, 101, 0.1);
}

.lade-form-input.success {
    border: 2px solid var(--lade-success);
    box-shadow: 
        inset 3px 3px 6px rgba(72, 187, 120, 0.2),
        inset -3px -3px 6px rgba(255, 255, 255, 0.1);
}

.lade-form-error {
    font-size: 12px;
    color: var(--lade-danger);
    margin-left: 4px;
    display: none;
    animation: ladeFadeIn 0.2s ease;
}

@keyframes ladeFadeIn {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
}

.lade-form-error.visible {
    display: block;
}

/* RSVP Table */
.lade-rsvp-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 16px;
}

.lade-rsvp-table th,
.lade-rsvp-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid rgba(163, 177, 198, 0.2);
}

.lade-rsvp-table th {
    font-size: 12px;
    font-weight: 600;
    color: var(--lade-text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.lade-rsvp-table td {
    font-size: 13px;
    color: var(--lade-text-secondary);
}

.lade-rsvp-table tr:hover td {
    background: var(--lade-bg-secondary);
}

.lade-status-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
}

.lade-status-badge.pending {
    background: var(--lade-pending);
    color: white;
}

.lade-status-badge.approved {
    background: var(--lade-approved);
    color: white;
}

.lade-status-badge.rejected {
    background: var(--lade-rejected);
    color: white;
}

.lade-status-badge.waitlist {
    background: var(--lade-info);
    color: white;
}

/* Admin Actions */
.lade-admin-actions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid rgba(163, 177, 198, 0.2);
}

.lade-admin-action-btn {
    padding: 10px 16px;
    border: none;
    border-radius: var(--lade-border-radius-xs);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all var(--lade-transition-fast);
}

.lade-admin-action-btn.primary {
    background: var(--lade-primary);
    color: white;
}

.lade-admin-action-btn.primary:hover {
    background: var(--lade-primary-hover);
}

.lade-admin-action-btn.success {
    background: var(--lade-success);
    color: white;
}

.lade-admin-action-btn.success:hover {
    background: var(--lade-success-hover);
}

.lade-admin-action-btn.danger {
    background: var(--lade-danger);
    color: white;
}

.lade-admin-action-btn.danger:hover {
    background: var(--lade-danger-hover);
}

.lade-admin-action-btn.secondary {
    background: var(--lade-bg-primary);
    color: var(--lade-text-secondary);
    box-shadow: 
        3px 3px 6px var(--lade-shadow-dark),
        -3px -3px 6px var(--lade-shadow-light);
}

.lade-admin-action-btn.secondary:hover {
    box-shadow: 
        inset 3px 3px 6px var(--lade-shadow-dark),
        inset -3px -3px 6px var(--lade-shadow-light);
}

/* Stats Cards */
.lade-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 12px;
    margin-bottom: 20px;
}

.lade-stat-card {
    padding: 16px;
    border-radius: var(--lade-border-radius-sm);
    background: var(--lade-bg-primary);
    box-shadow: 
        inset 4px 4px 8px var(--lade-shadow-dark),
        inset -4px -4px 8px var(--lade-shadow-light);
    text-align: center;
}

.lade-stat-value {
    font-size: 24px;
    font-weight: 700;
    color: var(--lade-primary);
    display: block;
}

.lade-stat-label {
    font-size: 11px;
    color: var(--lade-text-muted);
    text-transform: uppercase;
    margin-top: 4px;
}

/* Toast Notifications */
.lade-toast-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000002;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.lade-toast {
    min-width: 280px;
    max-width: 400px;
    padding: 14px 20px;
    border-radius: var(--lade-border-radius-sm);
    background: var(--lade-bg-primary);
    box-shadow: 
        8px 8px 16px var(--lade-shadow-dark),
        -8px -8px 16px var(--lade-shadow-light);
    display: flex;
    align-items: center;
    gap: 12px;
    animation: ladeSlideIn 0.3s ease;
}

@keyframes ladeSlideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.lade-toast.success {
    border-left: 4px solid var(--lade-success);
}

.lade-toast.error {
    border-left: 4px solid var(--lade-danger);
}

.lade-toast.warning {
    border-left: 4px solid var(--lade-warning);
}

.lade-toast.info {
    border-left: 4px solid var(--lade-info);
}

.lade-toast-icon {
    font-size: 18px;
}

.lade-toast-message {
    flex: 1;
    font-size: 14px;
    color: var(--lade-text-secondary);
}

.lade-toast-close {
    background: none;
    border: none;
    font-size: 18px;
    color: var(--lade-text-muted);
    cursor: pointer;
    padding: 4px;
}

/* Resize Handle */
.lade-resize-handle {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 20px;
    height: 20px;
    cursor: nwse-resize;
    background: linear-gradient(135deg, transparent 50%, var(--lade-shadow-dark) 50%);
    border-radius: 0 0 var(--lade-border-radius) 0;
    opacity: 0.5;
    transition: opacity var(--lade-transition-fast);
}

.lade-resize-handle:hover {
    opacity: 1;
}

/* Brading Footer */
.lade-branding {
    text-align: center;
    padding: 12px;
    border-top: 1px solid rgba(163, 177, 198, 0.2);
    font-size: 12px;
    color: var(--lade-text-muted);
    flex-shrink: 0;
}

.lade-branding a {
    color: var(--lade-primary);
    text-decoration: none;
    font-weight: 600;
}

.lade-branding a:hover {
    text-decoration: underline;
}

/* Responsive Design */
@media (max-width: 480px) {
    .lade-widget {
        top: 10px !important;
        right: 10px !important;
        left: 10px !important;
        width: auto !important;
        height: 80vh !important;
        max-height: 80vh;
    }
    
    .lade-dietary-options {
        grid-template-columns: 1fr;
    }
    
    .lade-admin-panel {
        width: 95vw;
    }
    
    .lade-rsvp-table {
        font-size: 12px;
    }
    
    .lade-rsvp-table th,
    .lade-rsvp-table td {
        padding: 8px 6px;
    }
}

/* Print Styles */
@media print {
    .lade-widget {
        position: static;
        box-shadow: none;
    }
    
    .lade-widget-header,
    .lade-admin-tab,
    .lade-resize-handle,
    .lade-branding {
        display: none;
    }
}
</style>

<script>
/**
 * LADE STACK RSVP WIDGET - COMPLETE CLIENT-SIDE IMPLEMENTATION
 * Version: 1.0.0
 * Author: Lade Stack
 * License: GPL v2 or later
 */

(function() {
    'use strict';
    
    // ============================================
    // CONFIGURATION & STATE MANAGEMENT
    // ============================================
    
    const LadeRSVP = {
        config: {},
        state: {
            rsvps: [],
            waitlist: [],
            approved: [],
            rejected: [],
            settings: {}
        },
        elements: {},
        
        // Initialize widget
        init: function() {
            const container = document.getElementById('lade-rsvp-widget-container');
            if (!container) return;
            
            // Load configuration from data attributes
            this.loadConfig(container);
            
            // Initialize storage
            this.initStorage();
            
            // Build widget HTML
            this.buildWidget();
            
            // Initialize functionality
            this.initDraggable();
            this.initResizable();
            this.initControls();
            this.initForm();
            this.initAdminPanel();
            
            // Start countdown if deadline set
            if (this.config.deadline) {
                this.startCountdown();
            }
            
            // Sync across tabs
            this.initTabSync();
            
            console.log('✅ Lade Stack RSVP Widget initialized for: ' + this.config.eventName);
        },
        
        // Load configuration from container data attributes
        loadConfig: function(container) {
            this.config = {
                eventId: container.dataset.eventId || 'default-event',
                eventName: container.dataset.eventName || 'Lade Stack Event',
                eventDate: container.dataset.eventDate || '',
                eventTime: container.dataset.eventTime || '',
                eventLocation: container.dataset.eventLocation || '',
                eventDescription: container.dataset.eventDescription || '',
                maxCapacity: parseInt(container.dataset.maxCapacity) || 50,
                waitlistEnabled: container.dataset.waitlistEnabled === 'true',
                fields: (container.dataset.fields || 'name,email,phone,guests,dietary').split(',').map(f => f.trim()),
                deadline: container.dataset.deadline || '',
                approvalMode: container.dataset.approvalMode === 'true',
                adminPassword: container.dataset.adminPassword || 'admin',
                emailjsService: container.dataset.emailjsService || '',
                emailjsTemplate: container.dataset.emailjsTemplate || '',
                emailjsKey: container.dataset.emailjsKey || '',
                theme: container.dataset.theme || 'light',
                position: container.dataset.position || 'bottom-right',
                showBranding: container.dataset.showBranding === 'true'
            };
        },

        // Initialize localStorage
        initStorage: function() {
            const storageKey = 'lade_rsvp_' + this.config.eventId;
            const saved = localStorage.getItem(storageKey);

            if (saved) {
                try {
                    const data = JSON.parse(saved);
                    this.state = { ...this.state, ...data };
                    
                    // Merge settings if available
                    if (data.settings) {
                        this.state.settings = data.settings;
                        // Update fields from settings if available
                        if (data.settings.fields) {
                            this.config.fields = data.settings.fields;
                        }
                        // Update capacity from settings if available
                        if (data.settings.capacity) {
                            this.config.maxCapacity = data.settings.capacity;
                        }
                    }
                } catch (e) {
                    console.warn('Could not parse saved RSVP data:', e);
                }
            } else {
                // Initialize with default settings
                this.state.settings = {
                    fields: this.config.fields,
                    capacity: this.config.maxCapacity
                };
            }

            // Save initial state
            this.saveState();
        },

        // Save state to localStorage
        saveState: function() {
            const storageKey = 'lade_rsvp_' + this.config.eventId;
            
            // Ensure settings are saved
            if (!this.state.settings) {
                this.state.settings = {
                    fields: this.config.fields,
                    capacity: this.config.maxCapacity
                };
            }
            
            localStorage.setItem(storageKey, JSON.stringify(this.state));

            // Update counter display
            this.updateCounter();
        },
        
        // Get remaining spots
        getRemainingSpots: function() {
            return this.config.maxCapacity - this.state.approved.length;
        },
        
        // Check if event is full
        isFull: function() {
            return this.getRemainingSpots() <= 0;
        },
        
        // Check if deadline has passed
        isDeadlinePassed: function() {
            if (!this.config.deadline) return false;
            const deadline = new Date(this.config.deadline + 'T23:59:59');
            return new Date() > deadline;
        },
        
        // ============================================
        // WIDGET HTML BUILDING
        // ============================================
        
        buildWidget: function() {
            const container = document.getElementById('lade-rsvp-widget-container');
            const defaultPosition = this.getDefaultPosition();
            
            container.innerHTML = `
                <div id="ladeWidget_${this.config.eventId}" class="lade-widget" data-theme="${this.config.theme}">
                    ${this.buildHeader()}
                    ${this.buildBody()}
                    ${this.buildFooter()}
                    <div class="lade-resize-handle" id="ladeResize_${this.config.eventId}"></div>
                </div>
                ${this.buildAdminPanel()}
                ${this.buildPasswordModal()}
                <div class="lade-toast-container" id="ladeToastContainer_${this.config.eventId}"></div>
            `;
            
            // Store element references
            this.elements.widget = document.getElementById('ladeWidget_' + this.config.eventId);
            this.elements.header = document.getElementById('ladeHeader_' + this.config.eventId);
            this.elements.body = document.getElementById('ladeBody_' + this.config.eventId);
            this.elements.form = document.getElementById('ladeForm_' + this.config.eventId);
            this.elements.counter = document.getElementById('ladeSpotsCount_' + this.config.eventId);
            
            // Apply saved position
            const savedState = this.getSavedWidgetState();
            if (savedState.position) {
                this.elements.widget.style.left = savedState.position.x + 'px';
                this.elements.widget.style.top = savedState.position.y + 'px';
            } else {
                this.elements.widget.style.left = defaultPosition.x + 'px';
                this.elements.widget.style.top = defaultPosition.y + 'px';
            }
            
            // Apply saved minimized state
            if (savedState.minimized) {
                this.elements.widget.classList.add('minimized');
            }
            
            // Initialize EmailJS if configured
            if (this.config.emailjsKey) {
                this.initEmailJS();
            }
        },
        
        buildHeader: function() {
            return `
                <div class="lade-widget-header" id="ladeHeader_${this.config.eventId}">
                    <div class="lade-header-left">
                        <span class="lade-drag-icon">⋮⋮</span>
                        <span class="lade-widget-title">${this.escapeHtml(this.config.eventName)}</span>
                    </div>
                    <div class="lade-widget-controls">
                        <button class="lade-settings-btn" id="ladeSettingsBtn_${this.config.eventId}" title="Toggle Fields">⚙️</button>
                        <button class="lade-control-btn minimize" title="Minimize">−</button>
                        <button class="lade-control-btn close" title="Close">×</button>
                    </div>
                </div>
            `;
        },
        
        buildBody: function() {
            let formContent = '';
            
            // Check deadline
            if (this.isDeadlinePassed()) {
                formContent = this.buildDeadlineExpired();
            } else if (this.isFull() && this.config.waitlistEnabled) {
                formContent = this.buildWaitlistForm();
            } else if (this.isFull()) {
                formContent = this.buildFullMessage();
            } else {
                formContent = this.buildRSVPForm();
            }
            
            return `
                <div class="lade-widget-body" id="ladeBody_${this.config.eventId}">
                    ${this.buildEventCard()}
                    ${this.buildCounter()}
                    ${formContent}
                </div>
            `;
        },
        
        buildEventCard: function() {
            let details = '';
            
            if (this.config.eventDate) {
                const dateDisplay = new Date(this.config.eventDate).toLocaleDateString('en-US', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                details += `
                    <div class="lade-event-detail">
                        <svg viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/></svg>
                        <span>${dateDisplay}${this.config.eventTime ? ' • ' + this.config.eventTime : ''}</span>
                    </div>
                `;
            }
            
            if (this.config.eventLocation) {
                details += `
                    <div class="lade-event-detail">
                        <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                        <span>${this.escapeHtml(this.config.eventLocation)}</span>
                    </div>
                `;
            }
            
            return `
                <div class="lade-event-card">
                    <div class="lade-event-name">${this.escapeHtml(this.config.eventName)}</div>
                    <div class="lade-event-details">${details}</div>
                </div>
            `;
        },

        buildCounter: function() {
            const remaining = this.getRemainingSpots();
            let badgeClass = 'lade-spots-badge';
            let statusText = `${remaining} spots remaining`;

            if (remaining <= 0) {
                badgeClass += ' full';
                statusText = 'Event Full';
            } else if (remaining <= 5) {
                badgeClass += ' critical-spots';
            } else if (remaining <= 10) {
                badgeClass += ' low-spots';
            }

            return `
                <div class="lade-spots-container">
                    <div class="${badgeClass}" id="ladeSpotsCount_${this.config.eventId}">
                        <span class="lade-spots-dot"></span>
                        <span>${statusText}</span>
                    </div>
                </div>
            `;
        },

        // Trigger confetti animation for low spots
        triggerConfetti: function() {
            const remaining = this.getRemainingSpots();
            
            if (remaining <= 5 && remaining > 0 && typeof confetti !== 'undefined') {
                // Low spots confetti
                confetti({
                    particleCount: 30,
                    spread: 50,
                    origin: { y: 0.7 },
                    colors: ['#ed8936', '#f56565'],
                    gravity: 0.8,
                    drift: 0,
                    scalar: 0.8
                });
            }
            
            if (remaining === 1 && typeof confetti !== 'undefined') {
                // Last spot celebration
                confetti({
                    particleCount: 100,
                    spread: 70,
                    origin: { y: 0.6 },
                    colors: ['#667eea', '#48bb78', '#ed8936'],
                    gravity: 0.9,
                    scalar: 1
                });
            }
        },
        
        buildRSVPForm: function() {
            const fields = this.config.fields;
            
            return `
                <form class="lade-form" id="ladeForm_${this.config.eventId}" onsubmit="return false;">
                    ${fields.includes('name') ? `
                    <div class="lade-form-group" id="ladeNameGroup_${this.config.eventId}">
                        <label class="lade-form-label" for="ladeName_${this.config.eventId}">
                            Full Name <span class="lade-required">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="ladeName_${this.config.eventId}" 
                            class="lade-form-input" 
                            placeholder="Enter your full name"
                            required
                            autocomplete="name"
                        >
                        <span class="lade-form-error" id="ladeNameError_${this.config.eventId}">Please enter your name</span>
                    </div>
                    ` : ''}
                    
                    ${fields.includes('email') ? `
                    <div class="lade-form-group" id="ladeEmailGroup_${this.config.eventId}">
                        <label class="lade-form-label" for="ladeEmail_${this.config.eventId}">
                            Email Address <span class="lade-required">*</span>
                        </label>
                        <input 
                            type="email" 
                            id="ladeEmail_${this.config.eventId}" 
                            class="lade-form-input" 
                            placeholder="Enter your email"
                            required
                            autocomplete="email"
                        >
                        <span class="lade-form-error" id="ladeEmailError_${this.config.eventId}">Please enter a valid email</span>
                    </div>
                    ` : ''}
                    
                    ${fields.includes('phone') ? `
                    <div class="lade-form-group" id="ladePhoneGroup_${this.config.eventId}">
                        <label class="lade-form-label" for="ladePhone_${this.config.eventId}">
                            Phone Number <span class="lade-required">*</span>
                        </label>
                        <input 
                            type="tel" 
                            id="ladePhone_${this.config.eventId}" 
                            class="lade-form-input" 
                            placeholder="Enter your phone number"
                            required
                            autocomplete="tel"
                        >
                        <span class="lade-form-error" id="ladePhoneError_${this.config.eventId}">Please enter a valid phone number</span>
                    </div>
                    ` : ''}
                    
                    ${fields.includes('guests') ? `
                    <div class="lade-form-group" id="ladeGuestsGroup_${this.config.eventId}">
                        <label class="lade-form-label" for="ladeGuests_${this.config.eventId}">
                            Number of Guests <span class="lade-required">*</span>
                        </label>
                        <select 
                            id="ladeGuests_${this.config.eventId}" 
                            class="lade-form-select"
                            required
                        >
                            <option value="">Select guests</option>
                            ${Array.from({length: 10}, (_, i) => `
                                <option value="${i + 1}">${i + 1} Guest${i > 0 ? 's' : ''}</option>
                            `).join('')}
                        </select>
                    </div>
                    ` : ''}
                    
                    ${fields.includes('dietary') ? `
                    <div class="lade-form-group" id="ladeDietaryGroup_${this.config.eventId}">
                        <label class="lade-form-label">Dietary Preferences (optional)</label>
                        <div class="lade-dietary-options">
                            <div class="lade-dietary-option">
                                <input type="checkbox" id="ladeDietVegan_${this.config.eventId}" value="Vegan">
                                <label for="ladeDietVegan_${this.config.eventId}">🌱 Vegan</label>
                            </div>
                            <div class="lade-dietary-option">
                                <input type="checkbox" id="ladeDietVegetarian_${this.config.eventId}" value="Vegetarian">
                                <label for="ladeDietVegetarian_${this.config.eventId}">🥬 Vegetarian</label>
                            </div>
                            <div class="lade-dietary-option">
                                <input type="checkbox" id="ladeDietGluten_${this.config.eventId}" value="Gluten-Free">
                                <label for="ladeDietGluten_${this.config.eventId}">🌾 Gluten-Free</label>
                            </div>
                            <div class="lade-dietary-option">
                                <input type="checkbox" id="ladeDietNut_${this.config.eventId}" value="Nut Allergy">
                                <label for="ladeDietNut_${this.config.eventId}">🥜 Nut Allergy</label>
                            </div>
                            <div class="lade-dietary-option">
                                <input type="checkbox" id="ladeDietNone_${this.config.eventId}" value="None">
                                <label for="ladeDietNone_${this.config.eventId}">✅ None</label>
                            </div>
                        </div>
                    </div>
                    ` : ''}
                    
                    <button 
                        type="submit" 
                        id="ladeSubmitBtn_${this.config.eventId}" 
                        class="lade-submit-btn"
                        disabled
                    >
                        Reserve My Spot
                    </button>
                </form>
            `;
        },
        
        buildWaitlistForm: function() {
            return `
                <div class="lade-waitlist-notice">
                    <h4>⏳ Event is Full</h4>
                    <p>Join the waitlist to be notified if spots become available.</p>
                </div>
                <form class="lade-form" id="ladeWaitlistForm_${this.config.eventId}" onsubmit="return false;">
                    <div class="lade-form-group">
                        <label class="lade-form-label" for="ladeWaitlistName_${this.config.eventId}">
                            Full Name <span class="lade-required">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="ladeWaitlistName_${this.config.eventId}" 
                            class="lade-form-input" 
                            placeholder="Enter your full name"
                            required
                        >
                    </div>
                    
                    <div class="lade-form-group">
                        <label class="lade-form-label" for="ladeWaitlistEmail_${this.config.eventId}">
                            Email Address <span class="lade-required">*</span>
                        </label>
                        <input 
                            type="email" 
                            id="ladeWaitlistEmail_${this.config.eventId}" 
                            class="lade-form-input" 
                            placeholder="Enter your email"
                            required
                        >
                    </div>
                    
                    <div class="lade-form-group">
                        <label class="lade-form-label" for="ladeWaitlistPhone_${this.config.eventId}">
                            Phone Number
                        </label>
                        <input 
                            type="tel" 
                            id="ladeWaitlistPhone_${this.config.eventId}" 
                            class="lade-form-input" 
                            placeholder="Enter your phone number"
                        >
                    </div>
                    
                    <button 
                        type="submit" 
                        id="ladeWaitlistSubmitBtn_${this.config.eventId}" 
                        class="lade-submit-btn"
                    >
                        Join Waitlist
                    </button>
                </form>
            `;
        },
        
        buildFullMessage: function() {
            return `
                <div class="lade-waitlist-notice">
                    <h4>🎉 Event is Full</h4>
                    <p>Sorry, all spots have been reserved. Check back for future events!</p>
                </div>
            `;
        },
        
        buildDeadlineExpired: function() {
            return `
                <div class="lade-deadline-expired">
                    <h4>⏰ RSVP Closed</h4>
                    <p>The deadline for RSVPs has passed.</p>
                </div>
            `;
        },
        
        buildFooter: function() {
            if (!this.config.showBranding) return '';
            
            return `
                <div class="lade-branding">
                    <a href="https://ladestack.in" target="_blank" rel="noopener">Lade Stack RSVP</a> • Free AI-Powered Widget
                </div>
            `;
        },
        
        buildAdminPanel: function() {
            return `
                <button class="lade-admin-tab" id="ladeAdminTab_${this.config.eventId}" title="Admin Dashboard">
                    ⚙️
                </button>
                
                <div class="lade-admin-panel" id="ladeAdminPanel_${this.config.eventId}">
                    <div class="lade-admin-panel-header">
                        <h3>📊 RSVP Dashboard</h3>
                        <button class="lade-admin-panel-close" id="ladeAdminClose_${this.config.eventId}">×</button>
                    </div>
                    <div class="lade-admin-panel-body">
                        <div class="lade-stats-grid">
                            <div class="lade-stat-card">
                                <span class="lade-stat-value" id="ladeStatTotal_${this.config.eventId}">0</span>
                                <span class="lade-stat-label">Total RSVPs</span>
                            </div>
                            <div class="lade-stat-card">
                                <span class="lade-stat-value" id="ladeStatApproved_${this.config.eventId}">${this.state.approved.length}</span>
                                <span class="lade-stat-label">Approved</span>
                            </div>
                            <div class="lade-stat-card">
                                <span class="lade-stat-value" id="ladeStatPending_${this.config.eventId}">${this.state.approvalMode ? this.state.rsvps.filter(r => r.status === 'pending').length : this.state.rsvps.length}</span>
                                <span class="lade-stat-label">Pending</span>
                            </div>
                            <div class="lade-stat-card">
                                <span class="lade-stat-value" id="ladeStatWaitlist_${this.config.eventId}">${this.state.waitlist.length}</span>
                                <span class="lade-stat-label">Waitlist</span>
                            </div>
                        </div>
                        
                        <div class="lade-admin-actions">
                            ${this.config.approvalMode ? `
                            <button class="lade-admin-action-btn success" id="ladeApproveAll_${this.config.eventId}">✓ Approve All</button>
                            ` : ''}
                            <button class="lade-admin-action-btn secondary" id="ladeExportCSV_${this.config.eventId}">📥 Export CSV</button>
                            <button class="lade-admin-action-btn danger" id="ladeClearAll_${this.config.eventId}">🗑️ Clear All</button>
                        </div>
                        
                        <table class="lade-rsvp-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Guests</th>
                                    <th>Status</th>
                                    ${this.config.approvalMode ? '<th>Actions</th>' : ''}
                                </tr>
                            </thead>
                            <tbody id="ladeRSVPTableBody_${this.config.eventId}">
                                <tr><td colspan="${this.config.approvalMode ? '5' : '4'}" style="text-align:center;">No RSVPs yet</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
        },
        
        buildPasswordModal: function() {
            return `
                <div class="lade-password-modal" id="ladePasswordModal_${this.config.eventId}">
                    <div class="lade-password-box">
                        <h4>🔐 Admin Access</h4>
                        <input
                            type="password"
                            class="lade-password-input"
                            id="ladePasswordInput_${this.config.eventId}"
                            placeholder="Enter admin password"
                        >
                        <button class="lade-password-btn" id="ladePasswordSubmit_${this.config.eventId}">
                            Access Dashboard
                        </button>
                    </div>
                </div>
                <div class="lade-field-modal" id="ladeFieldModal_${this.config.eventId}">
                    <div class="lade-field-box">
                        <h4>🔧 Toggle Form Fields</h4>
                        <div class="lade-field-options" id="ladeFieldOptions_${this.config.eventId}">
                            <div class="lade-field-option" data-field="name">
                                <label>
                                    <span class="field-icon">👤</span>
                                    Full Name
                                </label>
                                <input type="checkbox" checked disabled>
                            </div>
                            <div class="lade-field-option" data-field="email">
                                <label>
                                    <span class="field-icon">📧</span>
                                    Email Address
                                </label>
                                <input type="checkbox" checked disabled>
                            </div>
                            <div class="lade-field-option" data-field="phone">
                                <label>
                                    <span class="field-icon">📱</span>
                                    Phone Number
                                </label>
                                <input type="checkbox" id="ladeTogglePhone_${this.config.eventId}">
                            </div>
                            <div class="lade-field-option" data-field="guests">
                                <label>
                                    <span class="field-icon">👥</span>
                                    Number of Guests
                                </label>
                                <input type="checkbox" id="ladeToggleGuests_${this.config.eventId}">
                            </div>
                            <div class="lade-field-option" data-field="dietary">
                                <label>
                                    <span class="field-icon">🍽️</span>
                                    Dietary Preferences
                                </label>
                                <input type="checkbox" id="ladeToggleDietary_${this.config.eventId}">
                            </div>
                        </div>
                        <div class="lade-field-actions">
                            <button class="lade-field-btn secondary" id="ladeFieldCancel_${this.config.eventId}">Cancel</button>
                            <button class="lade-field-btn primary" id="ladeFieldSave_${this.config.eventId}">Save Changes</button>
                        </div>
                    </div>
                </div>
            `;
        },
        
        // ============================================
        // DRAGGABLE & RESIZABLE
        // ============================================
        
        initDraggable: function() {
            if (typeof interact === 'undefined') {
                console.warn('interact.js not loaded');
                return;
            }
            
            const widgetId = '#ladeWidget_' + this.config.eventId;
            const headerId = '#ladeHeader_' + this.config.eventId;
            
            interact(widgetId).draggable({
                allowFrom: headerId,
                listeners: {
                    start: (event) => {
                        event.target.classList.add('dragging');
                    },
                    move: (event) => {
                        const target = event.target;
                        const x = (parseFloat(target.dataset.x) || 0) + event.dx;
                        const y = (parseFloat(target.dataset.y) || 0) + event.dy;
                        
                        target.style.transform = `translate(${x}px, ${y}px)`;
                        target.dataset.x = x;
                        target.dataset.y = y;
                    },
                    end: (event) => {
                        event.target.classList.remove('dragging');
                        this.saveWidgetPosition();
                    }
                },
                modifiers: [
                    interact.modifiers.restrictRect({
                        restriction: 'parent',
                        endOnly: true
                    })
                ]
            });
        },
        
        initResizable: function() {
            if (typeof interact === 'undefined') {
                console.warn('interact.js not loaded');
                return;
            }
            
            const widgetId = '#ladeWidget_' + this.config.eventId;
            const resizeHandleId = '#ladeResize_' + this.config.eventId;
            
            interact(widgetId).resizable({
                edges: { right: true, bottom: true, left: false, top: false },
                listeners: {
                    move: (event) => {
                        let { x, y } = event.target.dataset;
                        x = (parseFloat(x) || 0) + event.deltaRect.left;
                        y = (parseFloat(y) || 0) + event.deltaRect.top;
                        
                        Object.assign(event.target.style, {
                            width: `${event.rect.width}px`,
                            height: `${event.rect.height}px`,
                            transform: `translate(${x}px, ${y}px)`
                        });
                        
                        Object.assign(event.target.dataset, { x, y });
                    }
                },
                modifiers: [
                    interact.modifiers.restrictSize({
                        min: { width: 340, height: 450 },
                        max: { width: 600, height: 800 }
                    })
                ],
                inertia: true
            });
        },
        
        saveWidgetPosition: function() {
            const widget = this.elements.widget;
            const transform = widget.style.transform;
            const match = transform.match(/translate\(([-\d.]+)px,\s*([-\d.]+)px\)/);
            
            let x = parseFloat(widget.style.left) || 0;
            let y = parseFloat(widget.style.top) || 0;
            
            if (match) {
                x += parseFloat(match[1]);
                y += parseFloat(match[2]);
            }
            
            const state = this.getSavedWidgetState();
            state.position = { x, y };
            localStorage.setItem('lade_rsvp_widget_state', JSON.stringify(state));
        },
        
        getSavedWidgetState: function() {
            try {
                const saved = localStorage.getItem('lade_rsvp_widget_state');
                if (saved) {
                    return JSON.parse(saved);
                }
            } catch (e) {
                console.warn('Could not load widget state:', e);
            }
            return { position: null, minimized: false };
        },
        
        getDefaultPosition: function() {
            const positions = {
                'bottom-right': { x: window.innerWidth - 440, y: window.innerHeight - 620 },
                'bottom-left': { x: 20, y: window.innerHeight - 620 },
                'top-right': { x: window.innerWidth - 440, y: 20 },
                'top-left': { x: 20, y: 20 }
            };
            return positions[this.config.position] || positions['bottom-right'];
        },
        
        // ============================================
        // CONTROLS (Minimize, Close)
        // ============================================

        initControls: function() {
            const widget = this.elements.widget;
            const minimizeBtn = widget.querySelector('.minimize');
            const closeBtn = widget.querySelector('.close');
            const settingsBtn = document.getElementById('ladeSettingsBtn_' + this.config.eventId);

            if (minimizeBtn) {
                minimizeBtn.addEventListener('click', () => {
                    widget.classList.toggle('minimized');
                    const isMinimized = widget.classList.contains('minimized');
                    minimizeBtn.textContent = isMinimized ? '+' : '−';

                    const state = this.getSavedWidgetState();
                    state.minimized = isMinimized;
                    localStorage.setItem('lade_rsvp_widget_state', JSON.stringify(state));
                });
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', () => {
                    widget.classList.add('hidden');
                    this.showToast('Widget hidden. Refresh page to show again.', 'info');
                });
            }

            // Field toggle modal
            if (settingsBtn) {
                settingsBtn.addEventListener('click', () => {
                    this.openFieldModal();
                });
            }

            // Field modal save/cancel
            const fieldModal = document.getElementById('ladeFieldModal_' + this.config.eventId);
            if (fieldModal) {
                const saveBtn = document.getElementById('ladeFieldSave_' + this.config.eventId);
                const cancelBtn = document.getElementById('ladeFieldCancel_' + this.config.eventId);

                if (saveBtn) {
                    saveBtn.addEventListener('click', () => {
                        this.saveFieldSettings();
                    });
                }

                if (cancelBtn) {
                    cancelBtn.addEventListener('click', () => {
                        fieldModal.classList.remove('active');
                    });
                }

                // Close on outside click
                fieldModal.addEventListener('click', (e) => {
                    if (e.target === fieldModal) {
                        fieldModal.classList.remove('active');
                    }
                });
            }
        },

        // Open field toggle modal
        openFieldModal: function() {
            const modal = document.getElementById('ladeFieldModal_' + this.config.eventId);
            if (!modal) return;

            // Set checkbox states based on current config
            const togglePhone = document.getElementById('ladeTogglePhone_' + this.config.eventId);
            const toggleGuests = document.getElementById('ladeToggleGuests_' + this.config.eventId);
            const toggleDietary = document.getElementById('ladeToggleDietary_' + this.config.eventId);

            if (togglePhone) togglePhone.checked = this.config.fields.includes('phone');
            if (toggleGuests) toggleGuests.checked = this.config.fields.includes('guests');
            if (toggleDietary) toggleDietary.checked = this.config.fields.includes('dietary');

            modal.classList.add('active');
        },

        // Save field settings
        saveFieldSettings: function() {
            const togglePhone = document.getElementById('ladeTogglePhone_' + this.config.eventId);
            const toggleGuests = document.getElementById('ladeToggleGuests_' + this.config.eventId);
            const toggleDietary = document.getElementById('ladeToggleDietary_' + this.config.eventId);

            // Build new fields array (name and email are always required)
            const newFields = ['name', 'email'];
            if (togglePhone && togglePhone.checked) newFields.push('phone');
            if (toggleGuests && toggleGuests.checked) newFields.push('guests');
            if (toggleDietary && toggleDietary.checked) newFields.push('dietary');

            // Update config
            this.config.fields = newFields;

            // Save to localStorage
            const state = this.getSavedWidgetState();
            state.settings = state.settings || {};
            state.settings.fields = newFields;
            localStorage.setItem('lade_rsvp_widget_state', JSON.stringify(state));

            // Close modal and rebuild form
            document.getElementById('ladeFieldModal_' + this.config.eventId).classList.remove('active');
            this.showToast('Fields updated! Rebuilding form...', 'success');

            // Rebuild widget after short delay
            setTimeout(() => {
                this.init();
            }, 1000);
        },
        
        // ============================================
        // FORM HANDLING & VALIDATION
        // ============================================
        
        initForm: function() {
            const form = this.elements.form;
            if (!form) {
                // Initialize waitlist form if main form doesn't exist
                const waitlistForm = document.getElementById('ladeWaitlistForm_' + this.config.eventId);
                if (waitlistForm) {
                    this.initWaitlistForm(waitlistForm);
                }
                return;
            }
            
            const submitBtn = document.getElementById('ladeSubmitBtn_' + this.config.eventId);
            const inputs = form.querySelectorAll('.lade-form-input, .lade-form-select');
            
            // Real-time validation
            inputs.forEach(input => {
                input.addEventListener('input', () => {
                    this.validateField(input);
                    this.checkFormValidity();
                });
            });
            
            // Form submission
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                this.handleFormSubmit();
            });
        },
        
        initWaitlistForm: function(form) {
            const submitBtn = document.getElementById('ladeWaitlistSubmitBtn_' + this.config.eventId);
            
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                this.handleWaitlistSubmit();
            });
        },

        validateField: function(input) {
            const value = input.value.trim();
            const errorEl = document.getElementById(input.id.replace('lade', 'ladeError').replace(this.config.eventId, this.config.eventId));
            let isValid = true;

            if (input.required && !value) {
                isValid = false;
            } else if (input.type === 'email') {
                isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
            } else if (input.type === 'tel') {
                isValid = /^[\d\s\-\+\(\)]{10,}$/.test(value);
            }

            if (errorEl) {
                errorEl.classList.toggle('visible', !isValid);
            }
            
            // Remove success class first
            input.classList.remove('success');
            
            // Add error or success class based on validation
            if (!isValid) {
                input.classList.add('error');
            } else if (value.length > 0) {
                input.classList.add('success');
                input.classList.remove('error');
            }

            return isValid;
        },

        checkFormValidity: function() {
            const form = this.elements.form;
            const submitBtn = document.getElementById('ladeSubmitBtn_' + this.config.eventId);
            const inputs = form.querySelectorAll('.lade-form-input[required], .lade-form-select[required]');

            let allValid = true;
            inputs.forEach(input => {
                if (!this.validateField(input)) {
                    allValid = false;
                }
            });

            if (submitBtn) {
                submitBtn.disabled = !allValid;
            }
        },

        handleFormSubmit: function() {
            const submitBtn = document.getElementById('ladeSubmitBtn_' + this.config.eventId);
            const widget = this.elements.widget;
            
            // Validate all fields first
            const form = this.elements.form;
            const inputs = form.querySelectorAll('.lade-form-input[required], .lade-form-select[required]');
            let hasErrors = false;
            
            inputs.forEach(input => {
                if (!this.validateField(input)) {
                    hasErrors = true;
                }
            });

            // Shake animation if errors
            if (hasErrors) {
                widget.classList.add('lade-shake');
                setTimeout(() => {
                    widget.classList.remove('lade-shake');
                }, 500);
                return;
            }

            submitBtn.classList.add('loading');
            submitBtn.textContent = 'Processing...';

            // Gather form data
            const formData = {
                id: 'rsvp_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9),
                name: document.getElementById('ladeName_' + this.config.eventId)?.value.trim() || '',
                email: document.getElementById('ladeEmail_' + this.config.eventId)?.value.trim() || '',
                phone: document.getElementById('ladePhone_' + this.config.eventId)?.value.trim() || '',
                guests: parseInt(document.getElementById('ladeGuests_' + this.config.eventId)?.value) || 1,
                dietary: [],
                status: this.config.approvalMode ? 'pending' : 'approved',
                timestamp: new Date().toISOString()
            };

            // Gather dietary preferences
            if (this.config.fields.includes('dietary')) {
                const dietaryOptions = ['Vegan', 'Vegetarian', 'Gluten-Free', 'Nut Allergy', 'None'];
                dietaryOptions.forEach(option => {
                    const checkbox = document.getElementById('ladeDiet' + option.replace(' ', '').replace('-', '') + '_' + this.config.eventId);
                    if (checkbox && checkbox.checked) {
                        formData.dietary.push(option);
                    }
                });
            }

            // Generate QR code data
            formData.qrData = JSON.stringify({
                id: formData.id,
                name: formData.name,
                event: this.config.eventName,
                date: this.config.eventDate,
                status: formData.status
            });

            // Log submitted data to console
            console.log('🎉 RSVP Submitted:', formData);

            // Simulate processing delay
            setTimeout(() => {
                // Add to state
                this.state.rsvps.push(formData);
                
                if (!this.config.approvalMode) {
                    this.state.approved.push(formData.id);
                }

                this.saveState();

                // Trigger confetti for low spots
                this.triggerConfetti();

                // Send email if EmailJS configured
                if (this.config.emailjsKey && formData.status === 'approved') {
                    this.sendConfirmationEmail(formData);
                }

                // Show success message
                this.showSuccessMessage(formData);

                submitBtn.classList.remove('loading');
                submitBtn.textContent = 'Reserve My Spot';
            }, 1500);
        },

        handleWaitlistSubmit: function() {
            const submitBtn = document.getElementById('ladeWaitlistSubmitBtn_' + this.config.eventId);
            submitBtn.classList.add('loading');
            submitBtn.textContent = 'Processing...';

            const formData = {
                id: 'waitlist_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9),
                name: document.getElementById('ladeWaitlistName_' + this.config.eventId).value.trim(),
                email: document.getElementById('ladeWaitlistEmail_' + this.config.eventId).value.trim(),
                phone: document.getElementById('ladeWaitlistPhone_' + this.config.eventId)?.value.trim() || '',
                timestamp: new Date().toISOString()
            };

            setTimeout(() => {
                this.state.waitlist.push(formData);
                this.saveState();
                
                this.showToast('✅ Added to waitlist! We\'ll notify you if spots open up.', 'success');
                
                // Rebuild widget to show confirmation
                setTimeout(() => {
                    this.init();
                }, 2000);
            }, 1000);
        },
        
        // ============================================
        // EMAILJS INTEGRATION
        // ============================================
        
        initEmailJS: function() {
            if (typeof emailjs !== 'undefined') {
                emailjs.init(this.config.emailjsKey);
            }
        },
        
        sendConfirmationEmail: function(rsvp) {
            if (!this.config.emailjsService || !this.config.emailjsTemplate) {
                return;
            }
            
            const templateParams = {
                name: rsvp.name,
                email: rsvp.email,
                event_name: this.config.eventName,
                event_date: this.config.eventDate,
                event_time: this.config.eventTime,
                event_location: this.config.eventLocation,
                guests: rsvp.guests,
                dietary: rsvp.dietary.join(', '),
                rsvp_id: rsvp.id
            };
            
            emailjs.send(this.config.emailjsService, this.config.emailjsTemplate, templateParams)
                .then(() => {
                    console.log('Email sent successfully');
                })
                .catch((error) => {
                    console.warn('EmailJS error:', error);
                });
        },
        
        // ============================================
        // SUCCESS MESSAGE & QR CODE
        // ============================================
        
        showSuccessMessage: function(rsvp) {
            const body = this.elements.body;
            body.innerHTML = `
                <div class="lade-success-message">
                    <div class="lade-success-icon">
                        <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                    </div>
                    <h3>RSVP Confirmed!</h3>
                    <p>Thank you, ${this.escapeHtml(rsvp.name)}! Your spot has been reserved.</p>
                    ${this.config.approvalMode && rsvp.status === 'pending' ? 
                        '<p style="color: var(--lade-warning);">⏳ Pending approval. You\'ll be notified once approved.</p>' : 
                        '<p>📧 Confirmation email sent to ' + this.escapeHtml(rsvp.email) + '</p>'
                    }
                    <div class="lade-qr-container" id="ladeQRContainer_${this.config.eventId}">
                        <div id="ladeQRCode_${this.config.eventId}"></div>
                        <button class="lade-qr-download" id="ladeQRDownload_${this.config.eventId}">
                            📥 Download QR Code
                        </button>
                    </div>
                    <button class="lade-submit-btn" onclick="location.reload()" style="margin-top: 16px;">
                        ← Back to Event
                    </button>
                </div>
            `;
            
            // Generate QR code
            this.generateQRCode(rsvp);
        },
        
        generateQRCode: function(rsvp) {
            if (typeof QRCode === 'undefined') {
                console.warn('QRCode.js not loaded');
                return;
            }
            
            const qrData = {
                id: rsvp.id,
                name: rsvp.name,
                event: this.config.eventName,
                status: rsvp.status
            };
            
            new QRCode(document.getElementById('ladeQRCode_' + this.config.eventId), {
                text: JSON.stringify(qrData),
                width: 150,
                height: 150,
                colorDark: '#2d3748',
                colorLight: '#e0e5ec',
                correctLevel: QRCode.CorrectLevel.M
            });
            
            // Store QR data for download
            this.currentQRData = qrData;
            
            // Add download handler
            setTimeout(() => {
                const downloadBtn = document.getElementById('ladeQRDownload_' + this.config.eventId);
                if (downloadBtn) {
                    downloadBtn.addEventListener('click', () => {
                        this.downloadQRCode();
                    });
                }
            }, 500);
        },
        
        downloadQRCode: function() {
            const canvas = document.querySelector('#ladeQRCode_' + this.config.eventId + ' canvas');
            if (!canvas) return;
            
            const link = document.createElement('a');
            link.download = `RSVP-${this.config.eventId}-${Date.now()}.png`;
            link.href = canvas.toDataURL('image/png');
            link.click();
            
            this.showToast('✅ QR Code downloaded!', 'success');
        },
        
        // ============================================
        // ADMIN DASHBOARD
        // ============================================
        
        initAdminPanel: function() {
            const adminTab = document.getElementById('ladeAdminTab_' + this.config.eventId);
            const adminPanel = document.getElementById('ladeAdminPanel_' + this.config.eventId);
            const adminClose = document.getElementById('ladeAdminClose_' + this.config.eventId);
            const passwordModal = document.getElementById('ladePasswordModal_' + this.config.eventId);
            const passwordSubmit = document.getElementById('ladePasswordSubmit_' + this.config.eventId);
            
            if (adminTab) {
                adminTab.addEventListener('click', () => {
                    passwordModal.classList.add('active');
                    document.getElementById('ladePasswordInput_' + this.config.eventId).focus();
                });
            }
            
            if (adminClose) {
                adminClose.addEventListener('click', () => {
                    adminPanel.classList.remove('active');
                });
            }
            
            if (passwordSubmit) {
                passwordSubmit.addEventListener('click', () => {
                    const input = document.getElementById('ladePasswordInput_' + this.config.eventId);
                    if (input.value === this.config.adminPassword) {
                        passwordModal.classList.remove('active');
                        adminPanel.classList.add('active');
                        this.renderAdminTable();
                        input.value = '';
                    } else {
                        this.showToast('❌ Incorrect password', 'error');
                        input.value = '';
                    }
                });
            }
            
            // Export CSV
            const exportBtn = document.getElementById('ladeExportCSV_' + this.config.eventId);
            if (exportBtn) {
                exportBtn.addEventListener('click', () => {
                    this.exportCSV();
                });
            }
            
            // Clear all
            const clearBtn = document.getElementById('ladeClearAll_' + this.config.eventId);
            if (clearBtn) {
                clearBtn.addEventListener('click', () => {
                    if (confirm('Are you sure? This will delete all RSVP data for this event.')) {
                        this.state.rsvps = [];
                        this.state.waitlist = [];
                        this.state.approved = [];
                        this.state.rejected = [];
                        this.saveState();
                        this.renderAdminTable();
                        this.showToast('✅ All data cleared', 'success');
                    }
                });
            }
            
            // Approve all
            const approveAllBtn = document.getElementById('ladeApproveAll_' + this.config.eventId);
            if (approveAllBtn) {
                approveAllBtn.addEventListener('click', () => {
                    this.state.rsvps.forEach(rsvp => {
                        if (rsvp.status === 'pending') {
                            rsvp.status = 'approved';
                            this.state.approved.push(rsvp.id);
                        }
                    });
                    this.saveState();
                    this.renderAdminTable();
                    this.showToast('✅ All pending RSVPs approved', 'success');
                });
            }
        },
        
        renderAdminTable: function() {
            const tbody = document.getElementById('ladeRSVPTableBody_' + this.config.eventId);
            if (!tbody) return;
            
            // Update stats
            document.getElementById('ladeStatTotal_' + this.config.eventId).textContent = this.state.rsvps.length;
            document.getElementById('ladeStatApproved_' + this.config.eventId).textContent = this.state.approved.length;
            document.getElementById('ladeStatPending_' + this.config.eventId).textContent = this.state.rsvps.filter(r => r.status === 'pending').length;
            document.getElementById('ladeStatWaitlist_' + this.config.eventId).textContent = this.state.waitlist.length;
            
            if (this.state.rsvps.length === 0) {
                tbody.innerHTML = `<tr><td colspan="${this.config.approvalMode ? '5' : '4'}" style="text-align:center;">No RSVPs yet</td></tr>`;
                return;
            }
            
            tbody.innerHTML = this.state.rsvps.map(rsvp => `
                <tr>
                    <td>${this.escapeHtml(rsvp.name)}</td>
                    <td>${this.escapeHtml(rsvp.email)}</td>
                    <td>${rsvp.guests || '-'}</td>
                    <td><span class="lade-status-badge ${rsvp.status}">${rsvp.status}</span></td>
                    ${this.config.approvalMode ? `
                    <td>
                        ${rsvp.status === 'pending' ? `
                        <button class="lade-admin-action-btn success" onclick="LadeRSVP.updateStatus('${rsvp.id}', 'approved')" style="padding: 4px 8px; font-size: 11px;">✓</button>
                        <button class="lade-admin-action-btn danger" onclick="LadeRSVP.updateStatus('${rsvp.id}', 'rejected')" style="padding: 4px 8px; font-size: 11px;">×</button>
                        ` : '-'}
                    </td>
                    ` : ''}
                </tr>
            `).join('');
        },
        
        updateStatus: function(id, status) {
            const rsvp = this.state.rsvps.find(r => r.id === id);
            if (!rsvp) return;
            
            rsvp.status = status;
            
            if (status === 'approved') {
                if (!this.state.approved.includes(id)) {
                    this.state.approved.push(id);
                }
                // Send approval email
                this.sendConfirmationEmail(rsvp);
            } else if (status === 'rejected') {
                this.state.approved = this.state.approved.filter(a => a !== id);
            }
            
            this.saveState();
            this.renderAdminTable();
            this.showToast(`RSVP ${status}`, 'success');
        },
        
        exportCSV: function() {
            if (this.state.rsvps.length === 0) {
                this.showToast('No data to export', 'warning');
                return;
            }
            
            const headers = ['ID', 'Name', 'Email', 'Phone', 'Guests', 'Dietary', 'Status', 'Timestamp'];
            const rows = this.state.rsvps.map(rsvp => [
                rsvp.id,
                rsvp.name,
                rsvp.email,
                rsvp.phone || '',
                rsvp.guests || '',
                (rsvp.dietary || []).join('; '),
                rsvp.status,
                rsvp.timestamp
            ]);
            
            const csv = [headers, ...rows].map(row => 
                row.map(cell => `"${String(cell).replace(/"/g, '""')}"`).join(',')
            ).join('\n');
            
            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = `RSVP-${this.config.eventId}-${new Date().toISOString().split('T')[0]}.csv`;
            link.click();
            
            this.showToast('✅ CSV exported!', 'success');
        },
        
        // ============================================
        // COUNTDOWN TIMER
        // ============================================
        
        startCountdown: function() {
            const updateCountdown = () => {
                if (this.isDeadlinePassed()) {
                    this.init(); // Rebuild widget to show expired message
                    return;
                }
                
                const deadline = new Date(this.config.deadline + 'T23:59:59');
                const now = new Date();
                const diff = deadline - now;
                
                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                
                const countdownEl = document.getElementById('ladeCountdown_' + this.config.eventId);
                if (countdownEl) {
                    countdownEl.innerHTML = `
                        <div class="lade-countdown-item">
                            <span class="lade-countdown-value">${String(days).padStart(2, '0')}</span>
                            <span class="lade-countdown-label">Days</span>
                        </div>
                        <div class="lade-countdown-item">
                            <span class="lade-countdown-value">${String(hours).padStart(2, '0')}</span>
                            <span class="lade-countdown-label">Hours</span>
                        </div>
                        <div class="lade-countdown-item">
                            <span class="lade-countdown-value">${String(minutes).padStart(2, '0')}</span>
                            <span class="lade-countdown-label">Mins</span>
                        </div>
                    `;
                }
            };
            
            updateCountdown();
            setInterval(updateCountdown, 60000); // Update every minute
        },
        
        // ============================================
        // UTILITIES
        // ============================================

        updateCounter: function() {
            const counter = this.elements.counter;
            if (!counter) return;

            const remaining = this.getRemainingSpots();
            let badgeClass = 'lade-spots-badge';
            let statusText = `${remaining} spots remaining`;

            if (remaining <= 0) {
                badgeClass += ' full';
                statusText = 'Event Full';
            } else if (remaining <= 5) {
                badgeClass += ' critical-spots';
            } else if (remaining <= 10) {
                badgeClass += ' low-spots';
            }

            // Remove animation class to re-trigger
            counter.style.animation = 'none';
            counter.offsetHeight; // Trigger reflow
            counter.style.animation = null;

            counter.className = badgeClass;
            counter.querySelector('span:last-child').textContent = statusText;
            
            // Trigger confetti for low spots
            if (remaining <= 5 && remaining > 0) {
                this.triggerConfetti();
            }
        },
        
        showToast: function(message, type = 'info') {
            const container = document.getElementById('ladeToastContainer_' + this.config.eventId);
            if (!container) return;
            
            const icons = {
                success: '✅',
                error: '❌',
                warning: '⚠️',
                info: 'ℹ️'
            };
            
            const toast = document.createElement('div');
            toast.className = `lade-toast ${type}`;
            toast.innerHTML = `
                <span class="lade-toast-icon">${icons[type]}</span>
                <span class="lade-toast-message">${this.escapeHtml(message)}</span>
                <button class="lade-toast-close">×</button>
            `;
            
            toast.querySelector('.lade-toast-close').addEventListener('click', () => {
                toast.remove();
            });
            
            container.appendChild(toast);
            
            // Auto-remove after 5 seconds
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 5000);
        },
        
        escapeHtml: function(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        },
        
        initTabSync: function() {
            window.addEventListener('storage', (event) => {
                if (event.key === 'lade_rsvp_' + this.config.eventId) {
                    try {
                        const data = JSON.parse(event.newValue);
                        this.state = { ...this.state, ...data };
                        this.updateCounter();
                        if (document.getElementById('ladeAdminPanel_' + this.config.eventId)?.classList.contains('active')) {
                            this.renderAdminTable();
                        }
                    } catch (e) {
                        console.warn('Storage sync error:', e);
                    }
                }
            });
        }
    };
    
    // Make LadeRSVP globally accessible for inline handlers
    window.LadeRSVP = LadeRSVP;
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => LadeRSVP.init());
    } else {
        LadeRSVP.init();
    }
    
})();
</script>
