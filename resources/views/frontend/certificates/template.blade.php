<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Certificate for {{ $enrollment->course->title }}</title>
    <style>
        @page {
            margin: 0;
            size: a4 landscape;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f0f4f8;
        }

        .cert-container {
            width: 100%;
            height: 100%;
            padding: 40px;
            box-sizing: border-box;
            background: #fff;
            position: relative;
            border: 20px solid #0a2283;
            /* Premium Blue Border */
        }

        .cert-inner {
            border: 2px solid #e2e8f0;
            height: 100%;
            padding: 60px;
            text-align: center;
            position: relative;
            box-sizing: border-box;
        }

        .cert-header {
            margin-bottom: 40px;
        }

        .logo-text {
            font-size: 32px;
            font-weight: bold;
            color: #0a2283;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }

        .cert-title {
            font-size: 56px;
            color: #1e293b;
            font-weight: 900;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .cert-subtitle {
            font-size: 20px;
            color: #64748b;
            margin-bottom: 50px;
        }

        .student-name {
            font-size: 48px;
            color: #0a2283;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 30px;
        }

        .course-details {
            font-size: 22px;
            color: #334155;
            line-height: 1.6;
            max-width: 800px;
            margin: 0 auto 60px;
        }

        .cert-footer {
            position: absolute;
            bottom: 60px;
            left: 60px;
            right: 60px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .signature-block {
            text-align: center;
            width: 200px;
            border-top: 1px solid #cbd5e1;
            padding-top: 10px;
        }

        .signature-name {
            font-weight: bold;
            color: #1e293b;
            font-size: 16px;
        }

        .signature-title {
            color: #64748b;
            font-size: 14px;
        }

        .cert-id {
            position: absolute;
            bottom: 20px;
            right: 40px;
            font-size: 12px;
            color: #94a3b8;
        }

        .cert-date {
            font-size: 18px;
            color: #475569;
            margin-top: 20px;
        }

        /* Achievement Badge */
        .badge-container {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .achievement-badge {
            width: 120px;
            height: 120px;
            background: #0a2283;
            color: white;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 5px double #fff;
        }
    </style>
</head>

<body>
    <div class="cert-container">
        <div class="cert-inner">
            <div class="badge-container">
                <div class="achievement-badge">
                    <span>SEAL OF</span><br>
                    <span>EXCELLENCE</span>
                </div>
            </div>

            <div class="cert-header">
                <div class="logo-text">eLEARNIFY</div>
                <div class="cert-title">Certificate</div>
                <div class="cert-subtitle">of Course Completion</div>
            </div>

            <div class="student-text" style="font-size: 24px; color: #64748b; margin-bottom: 20px;">
                This is to certify that
            </div>

            <div class="student-name">
                {{ strtoupper($enrollment->user->name) }}
            </div>

            <div class="course-details">
                has successfully completed the professional course on
                <strong>“{{ $enrollment->course->title }}”</strong> demonstrating exceptional understanding and
                dedication throughout the curriculum.
            </div>

            <div class="cert-date">
                Awarded on:
                <strong>{{ $enrollment->completed_at ? $enrollment->completed_at->format('F d, Y') : now()->format('F d, Y') }}</strong>
            </div>

            <div class="cert-footer" style="margin-top: 100px;">
                <table style="width: 100%;">
                    <tr>
                        <td style="text-align: left; width: 33%;">
                            <div class="signature-block">
                                <div class="signature-name">
                                    {{ $enrollment->course->instructor ? $enrollment->course->instructor->name : 'Course Instructor' }}
                                </div>
                                <div class="signature-title">Lead Instructor</div>
                            </div>
                        </td>
                        <td style="text-align: center; width: 34%;">
                            <!-- Central Decoration or QR if needed -->
                        </td>
                        <td style="text-align: right; width: 33%;">
                            <div class="signature-block" style="margin-left: auto;">
                                <div class="signature-name">eLEARNIFY Academy</div>
                                <div class="signature-title">Official Recognition</div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="cert-id">
                Certificate ID: eLN-{{ strtoupper(substr(md5($enrollment->id), 0, 10)) }}
            </div>
        </div>
    </div>
</body>

</html>
