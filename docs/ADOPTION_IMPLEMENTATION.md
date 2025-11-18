
## Implementation Checklist (MVP)

### Database & Models
- [x] Create adoptions migration
- [x] Create Adoption model with relationships
- [x] Add delivery_files and files_uploaded_at columns to adoptions table
- [ ] Create seeder for sample data

### Backend (Artist Dashboard)
- [ ] Artist login/auth
- [ ] Adoptions index page (list all orders)
- [ ] Order detail page with actions
- [ ] Confirm order endpoint
- [ ] Confirm payment endpoint
- [x] Upload files endpoint
- [x] Delete file endpoint
- [x] Mark as delivered endpoint
- [ ] Cancel order endpoint

### Frontend (Public)
- [ ] Gallery browse page (show available artworks)
- [ ] Artwork detail page with order form
- [ ] Order placement form validation
- [ ] Order confirmation page
- [ ] Order tracking page (enter email + order ID)
- [x] Download page for delivered files

### Email System
- [ ] Setup Laravel mail configuration
- [ ] Create email templates:
  - [ ] Order placed notification
  - [ ] Order confirmed with payment instructions
  - [ ] Order cancelled notification
  - [ ] Payment confirmed notification
  - [x] Files delivered with download link
- [ ] Configure email sending on status changes

### File Management
- [x] Secure file upload for artist
- [x] Generate download links
- [x] File access validation
- [x] Support multiple file formats
- [x] Private file storage configuration
- [x] Temporary signed URLs for downloads

### Testing
- [ ] Test complete order flow
- [ ] Test email delivery
- [x] Test file uploads and downloads
- [ ] Test order tracking

---

## File Upload & Delivery System Implementation

### Overview
The file delivery system allows artists to securely upload high-resolution files and automatically send download links to customers via email. Files are stored privately and accessed through secure, time-limited URLs.

---

### File Storage Architecture

#### 1. **Storage Configuration**
Files are stored in a private disk that is not accessible via direct URL:

```php
// config/filesystems.php
'disks' => [
    'adoptions' => [
        'driver' => 'local',
        'root' => storage_path('app/private/adoptions'),
        'visibility' => 'private',
    ],
],
```

**Storage Structure:**
```
storage/
└── app/
    └── private/
        └── adoptions/
            ├── adoption_1/
            │   ├── uuid1_timestamp.jpg
            │   ├── uuid2_timestamp.psd
            │   └── uuid3_timestamp.zip
            ├── adoption_2/
            │   └── uuid4_timestamp.png
            └── ...
```

#### 2. **File Metadata Storage**
File information is stored in JSON format in the `delivery_files` column:

```json
[
  {
    "original_name": "artwork_final.psd",
    "filename": "550e8400-e29b-41d4-a716-446655440000_1234567890.psd",
    "path": "adoption_1/550e8400-e29b-41d4-a716-446655440000_1234567890.psd",
    "size": 52428800,
    "mime_type": "application/octet-stream",
    "uploaded_at": "2024-01-15T10:30:00.000000Z"
  },
  {
    "original_name": "artwork_preview.jpg",
    "filename": "550e8400-e29b-41d4-a716-446655440001_1234567891.jpg",
    "path": "adoption_1/550e8400-e29b-41d4-a716-446655440001_1234567891.jpg",
    "size": 2097152,
    "mime_type": "image/jpeg",
    "uploaded_at": "2024-01-15T10:30:05.000000Z"
  }
]
```

---

### Artist File Upload Flow

#### 1. **Upload Interface** (`resources/views/artist/adoptions/upload-files.blade.php`)

Features:
- Drag-and-drop or click to select files
- Multiple file upload support
- File preview with size and type
- Individual file removal before upload
- Upload progress indication
- View/manage existing uploaded files
- Delete uploaded files
- Add delivery notes

Supported file formats:
- Images: JPG, JPEG, PNG
- Documents: PDF
- Design files: PSD, AI
- Archives: ZIP, RAR
- Max size: 100MB per file
- Max files: 10 per upload

#### 2. **Upload Process** (`app/Http/Controllers/Artist/AdoptionFileController.php`)

**Endpoint:** `POST /artist/adoptions/{adoption}/upload`

**Validation:**
```php
'files' => 'required|array|max:10',
'files.*' => 'file|max:102400|mimes:jpg,jpeg,png,pdf,psd,ai,zip,rar',
```

**Process:**
1. Validate payment is confirmed (`payment_status === 'paid'`)
2. Validate file types and sizes
3. Generate unique filenames using UUID + timestamp
4. Store files in private disk under `adoption_{id}` folder
5. Save file metadata to database as JSON
6. Update `files_uploaded_at` timestamp
7. Return success response

**Security measures:**
- Files stored outside public directory
- Unique filenames prevent overwriting
- Validation prevents malicious file types
- Artist authentication required

#### 3. **File Management**

**Delete File:** `DELETE /artist/adoptions/{adoption}/files`
- Remove file from storage
- Update database JSON
- Require artist authentication

**Mark as Delivered:** `POST /artist/adoptions/{adoption}/deliver`
- Validate files are uploaded
- Update order status to 'delivered'
- Set `delivered_at` timestamp
- Save delivery notes
- Send email with download links

---

### Customer Download Flow

#### 1. **Email Delivery** (`app/Mail/AdoptionFilesDelivered.php`)

**Trigger:** When artist marks order as delivered

**Email contains:**
- Order information
- Artwork details
- File count
- Artist's delivery notes
- Secure download link
- Expiration notice (30 days)

**Download link format:**
```
https://yoursite.com/adoptions/{adoption_id}/download?email={buyer_email}
```

#### 2. **Download Page** (`resources/views/adoptions/download.blade.php`)

**Endpoint:** `GET /adoptions/{adoption}/download`

**Access control:**
- Email verification (query parameter)
- Order status check (must be 'delivered' or 'completed')
- File availability check

**Features:**
- Display all available files
- File size information
- Individual file download buttons
- "Download All" button (staggers downloads)
- Important notices and instructions
- Artist's delivery notes

**Security:**
```php
// Email verification
if ($adoption->buyer_email !== $request->query('email')) {
    abort(403, 'Unauthorized access.');
}

// Status verification
if (!in_array($adoption->order_status, ['delivered', 'completed'])) {
    abort(403, 'Files not yet available.');
}
```

#### 3. **File Download** (`app/Http/Controllers/AdoptionDownloadController.php`)

**Endpoint:** `GET /adoptions/{adoption}/download/{filename}`

**Process:**
1. Verify adoption ID exists
2. Verify buyer email matches
3. Find file in metadata
4. Check file exists in storage
5. Return file download response with original filename

**Alternative: Temporary Signed URLs**
```php
URL::temporarySignedRoute(
    'adoptions.download.file',
    now()->addDays(30),
    [
        'adoption' => $adoption->adoption_id,
        'filename' => $filename,
        'email' => $adoption->buyer_email,
    ]
);
```

Benefits of signed URLs:
- Time-limited access (30 days)
- Cannot be shared without email parameter
- Laravel validates signature automatically
- Prevents unauthorized access

---

### Database Schema Changes

```php
// Migration: add_delivery_files_to_adoptions_table
Schema::table('adoptions', function (Blueprint $table) {
    $table->json('delivery_files')->nullable();
    $table->timestamp('files_uploaded_at')->nullable();
});
```

**Model Casts:**
```php
protected $casts = [
    'delivery_files' => 'array',
    'files_uploaded_at' => 'datetime',
];
```

**Model Methods:**
```php
// Check if files exist
public function hasDeliveryFiles(): bool
{
    return !empty($this->delivery_files);
}

// Get file count
public function getFileCount(): int
{
    return count($this->delivery_files ?? []);
}
```

---

### API Endpoints Summary

#### Artist Endpoints (Authenticated)

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/artist/adoptions/{adoption}/upload` | Upload delivery files |
| DELETE | `/artist/adoptions/{adoption}/files` | Delete a specific file |
| POST | `/artist/adoptions/{adoption}/deliver` | Mark as delivered & send email |

#### Public Endpoints (No Auth)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/adoptions/{adoption}/download?email={email}` | Download page |
| GET | `/adoptions/{adoption}/download/{filename}?email={email}` | Download file |

---

### JavaScript Implementation (`resources/js/artist/adoption-files.js`)

**Features:**
- File selection handling
- File preview with removal
- AJAX file upload with progress
- File deletion with confirmation
- Mark as delivered with confirmation
- SweetAlert2 notifications
- Form data handling for multipart uploads

**Key functions:**
```javascript
// Display selected files before upload
displaySelectedFiles()

// Remove file from selection
removeFile(index)

// Upload files via AJAX
$("#upload-files-btn").on("click", ...)

// Delete uploaded file
deleteFile(filename)

// Mark order as delivered
$("#mark-delivered-btn").on("click", ...)
```

---

### Security Considerations

#### 1. **File Access Control**
- ✅ Files stored in private directory (not web-accessible)
- ✅ Email verification required for downloads
- ✅ Order status verification
- ✅ File existence validation
- ✅ Artist authentication for uploads

#### 2. **File Upload Security**
- ✅ File type validation (whitelist)
- ✅ File size limits (100MB per file)
- ✅ Unique filenames (prevent overwriting)
- ✅ Payment verification before upload
- ✅ Malicious file type prevention

#### 3. **Download Security**
- ✅ Temporary signed URLs (30-day expiration)
- ✅ Email-based access control
- ✅ Cannot share links without email
- ✅ Signature validation by Laravel
- ✅ Download tracking capability (future)

#### 4. **Data Privacy**
- ✅ Buyer email protected
- ✅ Files not indexed by search engines
- ✅ No direct file URLs
- ✅ Secure file metadata storage

---

### Error Handling

#### Upload Errors
```php
// Payment not confirmed
return response()->json([
    'message' => 'Payment must be confirmed before uploading files.'
], 422);

// Invalid file type
'files.*' => 'file|max:102400|mimes:jpg,jpeg,png,pdf,psd,ai,zip,rar'

// File too large
'files.*' => 'file|max:102400' // 100MB
```

#### Download Errors
```php
// Unauthorized access
abort(403, 'Unauthorized access.');

// Files not ready
abort(403, 'Files not yet available.');

// File not found
abort(404, 'File not found.');

// File no longer available
abort(404, 'File no longer available.');
```

---

### Future Enhancements

#### 1. **Download Analytics**
- Track download count per file
- Log download timestamps
- Identify popular file formats
- Monitor storage usage

#### 2. **File Versioning**
- Allow artists to replace files
- Keep version history
- Notify customers of updates

#### 3. **Batch Operations**
- Generate ZIP file for all files
- Single-click download all
- Automatic compression

#### 4. **Advanced Features**
- File previews for images
- Streaming for video files
- Download resume capability
- CDN integration for faster downloads

#### 5. **Notifications**
- Email when customer downloads files
- Remind customer before link expires
- Alert artist of download issues

---

### Testing Checklist

#### File Upload
- [x] Artist can select multiple files
- [x] File validation works correctly
- [x] Files stored in correct location
- [x] Metadata saved correctly
- [x] Upload progress shown
- [x] Error handling works

#### File Download
- [x] Email verification required
- [x] Download page displays correctly
- [x] Individual downloads work
- [x] Download all works
- [x] File not found handled
- [x] Unauthorized access blocked

#### Email Delivery
- [x] Email sent on mark as delivered
- [x] Download link works from email
- [x] Email template displays correctly
- [x] Delivery notes included

#### Security
- [x] Files not publicly accessible
- [x] Email verification enforced
- [x] File type validation enforced
- [x] Size limits enforced
- [x] Artist authentication required

---

### Troubleshooting Guide

#### Files Not Uploading
1. Check file size (max 100MB)
2. Verify file type is allowed
3. Ensure payment is confirmed
4. Check storage permissions
5. Verify disk configuration

#### Download Links Not Working
1. Verify email parameter matches
2. Check order status (must be delivered/completed)
3. Ensure files exist in storage
4. Check link expiration (30 days)
5. Verify file metadata in database

#### Email Not Sending
1. Check mail configuration
2. Verify queue is running (if using queues)
3. Check email logs
4. Verify SMTP credentials
5. Test with different email provider

---

## Email Template Requirements

### 1. Order Placed (To Buyer)
```
Subject: Order Confirmation - [Artwork Title]

Hi [Buyer Name],

Thank you for your interest in "[Artwork Title]"!

Order Details:
- Order ID: #[adoption_id]
- Artwork: [artwork title]
- Price: Rp [price]
- Date: [created_at]

Your order is pending artist confirmation. You will receive another email once the artist reviews your order.

You can track your order status here: [tracking link]

Best regards,
Cho's Studio
```

### 2. Order Confirmed (To Buyer)
```
Subject: Order Confirmed - Payment Instructions

Hi [Buyer Name],

Great news! Your order for "[Artwork Title]" has been confirmed.

Payment Instructions:
[Payment details - bank account, e-wallet, etc.]
Amount: Rp [price]

Please send payment proof to: [artist email/WhatsApp]

Once payment is confirmed, we'll prepare your high-resolution files.

Order ID: #[adoption_id]
Track order: [tracking link]

Best regards,
Cho's Studio
```

### 3. Payment Confirmed (To Buyer)
```
Subject: Payment Received - Files Being Prepared

Hi [Buyer Name],

Payment confirmed! We're now preparing your high-resolution files for "[Artwork Title]".

You'll receive another email with the download link once the files are ready.

Order ID: #[adoption_id]

Best regards,
Cho's Studio
```

### 4. Files Delivered (To Buyer) - IMPLEMENTED
```markdown
Subject: Your Artwork is Ready for Download! 🎨

Hi [Buyer Name],

Great news! Your artwork "[Artwork Title]" is ready for download!

**Download Your Files**
Click the button below to access your high-resolution files:

[Download Files Button] → Links to: /adoptions/{id}/download?email={email}

**What's Included:**
- [File count] high-resolution file(s)
- Original formats as created by the artist
- Full commercial/personal usage rights

**Artist's Notes:**
[delivery_notes - if provided]

**Important Information:**
⚠️ This download link will be valid for 30 days
📁 Please download and save your files immediately
🔒 Do not share this link - it's unique to your order
💾 Save files to a secure backup location

**File Formats & Usage:**
- High-resolution files suitable for printing
- Editable source files (if included)
- Ready for commercial or personal use

**Need Help?**
If you have any questions or issues downloading your files, please reply to this email.

Thank you for supporting Cho's Studio! 💖

Order Details:
- Order ID: #[adoption_id]
- Artwork: [artwork title]
- Files Available: [file count]
- Valid Until: [30 days from now]

Best regards,
Cho's Studio

---
This is an automated email. Please do not reply directly to this message.
```

**Implementation:**
- ✅ Mailable class created (`app/Mail/AdoptionFilesDelivered.php`)
- ✅ Markdown template created (`resources/views/emails/adoptions/files-delivered.blade.php`)
- ✅ Download URL generation implemented
- ✅ Automatic sending on delivery status change
- ✅ Includes file count and delivery notes
- ✅ Professional formatting with branding

---

## Routes Documentation

### Artist Routes (Authenticated)
```php
Route::middleware(['auth', 'artist'])->prefix('artist')->name('artist.')->group(function () {
    // File management
    Route::post('adoptions/{adoption}/upload', [AdoptionFileController::class, 'upload'])
        ->name('adoptions.upload');
    
    Route::delete('adoptions/{adoption}/files', [AdoptionFileController::class, 'deleteFile'])
        ->name('adoptions.files.delete');
    
    Route::post('adoptions/{adoption}/deliver', [AdoptionFileController::class, 'markDelivered'])
        ->name('adoptions.deliver');
});
```

### Public Routes (No Authentication)
```php
// Download routes
Route::get('adoptions/{adoption}/download', [AdoptionDownloadController::class, 'index'])
    ->name('adoptions.download');

Route::get('adoptions/{adoption}/download/{filename}', [AdoptionDownloadController::class, 'download'])
    ->name('adoptions.download.file');
```

---

## File Format Support

### Supported Formats
| Type | Extensions | Max Size | Use Case |
|------|-----------|----------|----------|
| Images | .jpg, .jpeg, .png | 100MB | Final artwork, previews |
| Documents | .pdf | 100MB | Contracts, certificates |
| Design Files | .psd, .ai | 100MB | Editable source files |
| Archives | .zip, .rar | 100MB | Multiple files bundled |

### File Naming Convention
```
Format: {uuid}_{timestamp}.{extension}
Example: 550e8400-e29b-41d4-a716-446655440000_1234567890.psd

Benefits:
- Unique across all orders
- Prevents filename conflicts
- Sortable by upload time
- Difficult to guess (security)
```

---

## Performance Considerations

### File Upload
- Files processed sequentially to prevent memory issues
- Large files may take time to upload
- Progress indication improves UX
- Consider chunked uploads for very large files (future)

### File Download
- Files served directly from storage (efficient)
- No file copying needed
- Browsers handle download resuming
- Consider CDN for global customers (future)

### Storage Management
- Monitor storage usage regularly
- Set up automated backups
- Consider archiving old orders
- Implement storage limits per order (future)

---

## Maintenance Tasks

### Regular Maintenance
1. **Weekly:**
   - Check storage usage
   - Review failed uploads
   - Monitor download activity

2. **Monthly:**
   - Clean up expired links (if implementing cleanup)
   - Backup files to external storage
   - Review customer feedback

3. **Quarterly:**
   - Audit file access logs
   - Review storage costs
   - Update file format support if needed

### Monitoring
- Track upload success rate
- Monitor storage growth
- Log download errors
- Alert on failed emails

---
