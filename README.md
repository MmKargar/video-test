# WebM Video Player - iOS Compatibility Test

Simple HTML video player for testing WebM playback on iOS devices.

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

## iOS Compatibility

- **iOS 17.4+**: Full WebM support
- **iOS 18+**: Full WebM support
- **iOS 14.0-17.3**: Partial support (may not work reliably)
- **Note**: WebM alpha transparency is not supported on iOS
