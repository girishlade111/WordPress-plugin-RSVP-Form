#!/bin/bash
# =============================================================================
# Lade Stack RSVP Widget - Build Script for Linux/Mac
# Creates production-ready ZIP package for WordPress.org submission
# =============================================================================

set -e  # Exit on error

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Variables
PLUGIN_NAME="lade-stack-rsvp"
VERSION="1.0.0"
BUILD_DIR="build"
DIST_DIR="${BUILD_DIR}/${PLUGIN_NAME}"

echo ""
echo "============================================================================="
echo " Lade Stack RSVP Widget - Build Script"
echo " Creating production package..."
echo "============================================================================="
echo ""

# Clean previous build
if [ -d "$BUILD_DIR" ]; then
    echo -e "${YELLOW}[CLEAN]${NC} Removing old build directory..."
    rm -rf "$BUILD_DIR"
fi

# Create build directory
echo -e "${GREEN}[CREATE]${NC} Creating build directory..."
mkdir -p "$DIST_DIR"

# Copy plugin files (excluding files in .distignore)
echo -e "${GREEN}[COPY]${NC} Copying plugin files..."
rsync -av --exclude-from='.distignore' \
    "${PLUGIN_NAME}/" \
    "$DIST_DIR/"

# Remove additional dev files
echo -e "${YELLOW}[REMOVE]${NC} Removing development files..."
rm -f "$DIST_DIR/DEBUG-REPORT.md"
rm -f "$DIST_DIR/CREDENTIALS-TEMPLATE.md"
rm -f "$DIST_DIR/.env.example"
rm -f "$DIST_DIR/test-widget.html"

# Create ZIP file
echo -e "${GREEN}[ZIP]${NC} Creating ZIP archive..."
cd "$BUILD_DIR"
zip -r "${PLUGIN_NAME}.${VERSION}.zip" "${PLUGIN_NAME}/" > /dev/null
cd ..

# Calculate size
SIZE=$(stat -f%z "${BUILD_DIR}/${PLUGIN_NAME}.${VERSION}.zip" 2>/dev/null || stat -c%s "${BUILD_DIR}/${PLUGIN_NAME}.${VERSION}.zip" 2>/dev/null || echo "0")
SIZE_KB=$((SIZE / 1024))

echo ""
echo "============================================================================="
echo -e " ${GREEN}Build Complete!${NC}"
echo "============================================================================="
echo ""
echo " Package: ${BUILD_DIR}/${PLUGIN_NAME}.${VERSION}.zip"
echo " Size: ${SIZE_KB} KB"
echo ""
echo " Next Steps:"
echo " 1. Test the ZIP file on a clean WordPress installation"
echo " 2. Upload to WordPress.org plugin repository"
echo " 3. Share with users!"
echo ""
echo "============================================================================="
