<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Certificate for {{ $enrollment->course->title }}</title>
    <style>
        @page {
            margin: 0;
            size: 297mm 210mm;
        }

        * {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 297mm;
            height: 210mm;
            font-family: 'Times-Roman', serif;
            color: #1a365d;
            background-color: #fff;
        }

        .cert-wrapper {
            width: 297mm;
            height: 210mm;
            position: relative;
            background: #fff;
            overflow: hidden;
            border: 2mm solid #e2e8f0;
        }

        /* Decorative Corners */
        .corner {
            position: absolute;
            width: 80mm;
            height: 80mm;
            z-index: 1;
        }

        .top-left {
            top: -20mm;
            left: -20mm;
            background: linear-gradient(135deg, #0a2283 50%, #1e40af 50%);
            transform: rotate(-45deg);
        }

        .top-left-accent {
            position: absolute;
            top: 25mm;
            left: 5mm;
            width: 100mm;
            height: 2mm;
            background: #fbbf24;
            /* Gold */
            transform: rotate(-45deg);
            z-index: 2;
        }

        .bottom-right {
            bottom: -20mm;
            right: -20mm;
            background: linear-gradient(135deg, #1e40af 50%, #0a2283 50%);
            transform: rotate(-45deg);
        }

        .bottom-right-accent {
            position: absolute;
            bottom: 25mm;
            right: 5mm;
            width: 100mm;
            height: 2mm;
            background: #fbbf24;
            transform: rotate(-45deg);
            z-index: 2;
        }

        /* Main Content */
        .content {
            position: relative;
            z-index: 10;
            padding: 20mm 40mm;
            text-align: center;
        }

        .cert-title {
            font-size: 56pt;
            font-weight: bold;
            color: #0c4a6e;
            text-transform: uppercase;
            margin-bottom: 2mm;
            letter-spacing: 5pt;
        }

        .cert-subtitle {
            font-size: 24pt;
            font-style: italic;
            color: #1e3a8a;
            letter-spacing: 2pt;
            margin-bottom: 15mm;
            border-bottom: 1px solid #1e3a8a;
            display: inline-block;
            padding-bottom: 5mm;
        }

        .presentation-text {
            font-size: 18pt;
            color: #334155;
            margin-bottom: 10mm;
        }

        .student-name {
            font-family: 'ZapfChancery', cursive;
            font-size: 72pt;
            color: #1e40af;
            margin: 5mm 0 10mm;
            line-height: 1;
        }

        .description {
            font-size: 16pt;
            color: #475569;
            line-height: 1.6;
            margin-bottom: 20mm;
            max-width: 220mm;
            margin-left: auto;
            margin-right: auto;
        }

        .description strong {
            color: #0c4a6e;
        }

        /* Footer / Signature */
        .footer {
            position: absolute;
            bottom: 25mm;
            left: 40mm;
            right: 40mm;
        }

        .signature-area {
            width: 80mm;
            margin: 0 auto;
            text-align: center;
        }

        .signature-line {
            margin-top: 5mm;
            padding-top: 3mm;
        }

        .signer-name {
            font-size: 16pt;
            font-weight: bold;
            color: #0c4a6e;
            text-transform: uppercase;
        }

        .signer-title {
            font-size: 12pt;
            color: #64748b;
            text-transform: uppercase;
        }

        /* Badge/Ribbon */
        .badge-wrapper {
            position: absolute;
            top: 40mm;
            right: 35mm;
            z-index: 20;
        }

        .ribbon {
            width: 35mm;
            position: relative;
            background: #0a2283;
            color: #fff;
            text-align: center;
            padding: 12mm 0;
            border-radius: 50%;
            border: 2mm solid #fbbf24;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: block;
        }

        .badge-inner {
            font-size: 9pt;
            font-weight: bold;
            line-height: 1.2;
            margin-top: 2mm;
        }
    </style>
</head>

<body>
    <div class="cert-wrapper">
        <!-- Decorative Shapes -->
        <div class="corner top-left"></div>
        <div class="top-left-accent"></div>

        <div class="corner bottom-right"></div>
        <div class="bottom-right-accent"></div>

        <div class="badge-wrapper">
            <div class="ribbon">
                <div class="badge-inner">
                    ELERNIFY<br>OFFICIAL<br>ACADEMY
                </div>
            </div>
        </div>

        <div class="content">
            <div class="cert-title">Certificate</div>
            <div class="cert-subtitle">OF COMPLETION</div>

            <div class="presentation-text">This certificate is presented to</div>

            <div class="student-name">
                {{ $enrollment->user->name }}
            </div>

            <div class="description">
                in recognition of their successful completion of the course
                <strong>“{{ $enrollment->course->title }}”</strong>.
                Your commitment, enthusiasm, and dedication have been an integral part of your success,
                and we are pleased to recognize your achievement.
            </div>

            <div class="footer">
                <div class="signature-area">
                    <div class="signature-line">
                        <div class="signer-name">
                            {{ $enrollment->course->instructor ? $enrollment->course->instructor->name : 'E-Learnify Academy' }}
                        </div>
                        <div class="signer-title">
                            {{ $enrollment->course->instructor ? 'Lead Instructor' : 'Academic Director' }}</div>
                    </div>
                </div>

                <div style="margin-top: 5mm; font-size: 10pt; color: #94a3b8;">
                    Awarded on:
                    {{ $enrollment->completed_at ? $enrollment->completed_at->format('F d, Y') : now()->format('F d, Y') }}<br>
                    ID: eLN-{{ strtoupper(substr(md5($enrollment->id), 0, 10)) }}
                </div>
            </div>
        </div>
    </div>
</body>
</body>

</html>
