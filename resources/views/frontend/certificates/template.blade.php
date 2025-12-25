<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Certificate of Completion</title>
    <style>
        @page {
            margin: 20px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            background: white;
            width: 100%;
            height: 100%;
        }

        .certificate-wrapper {
            width: 100%;
            height: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .certificate {
            background: white;
            width: 100%;
            height: 100%;
            padding: 35px 50px;
            border: 12px solid #f0f0f0;
            position: relative;
        }

        .inner-border {
            position: absolute;
            top: 25px;
            left: 25px;
            right: 25px;
            bottom: 25px;
            border: 2px solid #667eea;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
            position: relative;
            z-index: 2;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
            letter-spacing: 2px;
        }

        .certificate-title {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 12px;
        }

        .main-title {
            font-size: 24px;
            color: #333;
            margin-bottom: 18px;
            font-weight: normal;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .recipient {
            text-align: center;
            margin: 15px 0;
            position: relative;
            z-index: 2;
        }

        .label {
            font-size: 10px;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 6px;
        }

        .name {
            font-size: 32px;
            color: #667eea;
            font-weight: bold;
            margin-bottom: 12px;
            border-bottom: 3px solid #667eea;
            display: inline-block;
            padding-bottom: 6px;
        }

        .description {
            font-size: 13px;
            color: #666;
            line-height: 1.5;
            text-align: center;
            margin: 12px auto;
            max-width: 600px;
            position: relative;
            z-index: 2;
        }

        .course-name {
            font-size: 22px;
            color: #333;
            font-weight: bold;
            margin: 12px 0;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .footer {
            position: absolute;
            bottom: 50px;
            left: 50px;
            right: 50px;
            display: table;
            width: calc(100% - 100px);
            border-top: 1px solid #ddd;
            padding-top: 15px;
            z-index: 2;
        }

        .signature {
            display: table-cell;
            text-align: center;
            width: 33%;
        }

        .signature-line {
            border-top: 2px solid #333;
            width: 130px;
            margin: 0 auto 6px;
        }

        .signature-name {
            font-weight: bold;
            color: #333;
            margin-bottom: 2px;
            font-size: 12px;
        }

        .signature-title {
            font-size: 10px;
            color: #999;
        }

        .date-section {
            text-align: center;
            margin-top: 15px;
            position: relative;
            z-index: 2;
        }

        .date {
            font-size: 12px;
            color: #666;
            font-weight: bold;
        }

        .seal {
            position: absolute;
            bottom: 60px;
            right: 70px;
            width: 80px;
            height: 80px;
            border: 3px solid #667eea;
            border-radius: 50%;
            background: white;
            z-index: 10;
            text-align: center;
            padding-top: 22px;
        }

        .seal-text {
            font-size: 8px;
            color: #667eea;
            font-weight: bold;
            line-height: 1.3;
        }

        .decorative-corner {
            position: absolute;
            width: 50px;
            height: 50px;
            z-index: 1;
        }

        .corner-tl {
            top: 20px;
            left: 20px;
            border-top: 3px solid #667eea;
            border-left: 3px solid #667eea;
        }

        .corner-tr {
            top: 20px;
            right: 20px;
            border-top: 3px solid #667eea;
            border-right: 3px solid #667eea;
        }

        .corner-bl {
            bottom: 20px;
            left: 20px;
            border-bottom: 3px solid #667eea;
            border-left: 3px solid #667eea;
        }

        .corner-br {
            bottom: 20px;
            right: 20px;
            border-bottom: 3px solid #667eea;
            border-right: 3px solid #667eea;
        }
    </style>
</head>

<body>
    <div class="certificate-wrapper">
        <div class="certificate">
            <div class="inner-border"></div>
            <div class="decorative-corner corner-tl"></div>
            <div class="decorative-corner corner-tr"></div>
            <div class="decorative-corner corner-bl"></div>
            <div class="decorative-corner corner-br"></div>

            <div class="header">
                <div class="logo">eLEARNIFY</div>
                <div class="certificate-title">Certificate of Completion</div>
            </div>

            <div class="main-title">This is to certify that</div>

            <div class="recipient">
                <div class="label">Student Name</div>
                <div class="name">{{ $enrollment->user->name }}</div>
            </div>

            <div class="description">
                has successfully completed the online course
            </div>

            <div class="recipient">
                <div class="course-name">{{ $enrollment->course->title }}</div>
            </div>

            <div class="description">
                with dedication and commitment, demonstrating proficiency in the subject matter.<br>
                This achievement reflects exceptional hard work and determination to excel in learning.
            </div>

            <div class="date-section">
                <div class="label">Date of Completion</div>
                <div class="date">{{ $enrollment->updated_at->format('F d, Y') }}</div>
            </div>

            <div class="footer">
                <div class="signature">
                    <div class="signature-line"></div>
                    <div class="signature-name">{{ $enrollment->course->instructor->name ?? 'Instructor' }}</div>
                    <div class="signature-title">Course Instructor</div>
                </div>
                <div class="signature">
                    <div class="signature-line"></div>
                    <div class="signature-name">eLEARNIFY</div>
                    <div class="signature-title">Learning Platform</div>
                </div>
                <div class="signature">
                    <div class="signature-line"></div>
                    <div class="signature-name">Certificate ID</div>
                    <div class="signature-title">#{{ str_pad($enrollment->id, 6, '0', STR_PAD_LEFT) }}</div>
                </div>
            </div>

            <div class="seal">
                <div class="seal-text">VERIFIED<br>CERTIFICATE</div>
            </div>
        </div>
    </div>
</body>

</html>
