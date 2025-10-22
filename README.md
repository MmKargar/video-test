# WebM Video Player - iOS Compatibility Test

Simple HTML video player for testing WebM playback on iOS devices.

## Requirements

- PHP CLI (for local server)
- iOS device with iOS 17.4+ or iOS 18+ for full WebM support

## Testing Instructions

1. **Start the local server:**
   ```bash
   php -S 0.0.0.0:2020
   ```

2. **Access from iOS device:**
   - Find your computer's IP address (e.g., `192.168.1.100`)
   - Open Safari on your iOS device
   - Navigate to `http://YOUR_IP:2020`
   - Example: `http://192.168.1.100:2020`

3. **Test video playback:**
   - The video player should load automatically
   - Tap play to test WebM playback
   - Use native iOS video controls

## iOS Compatibility

- **iOS 17.4+**: Full WebM support
- **iOS 18+**: Full WebM support
- **iOS 14.0-17.3**: Partial support (may not work reliably)
- **Note**: WebM alpha transparency is not supported on iOS

## Files

- `index.html` - HTML video player (pure HTML/CSS, no external dependencies)
- `fe3d32918a6f41c5b429472794f8ba69.webm` - Test video file
- `README.md` - This file
