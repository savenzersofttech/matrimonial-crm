<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lead Profile PDF</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
            line-height: 1.7;
            margin: 40px;
            background: #f4f8fc;
        }

        h1 {
            text-align: center;
            color: #fff;
            background: #007bff;
            padding: 20px 40px;
            border-radius: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .section {
            background: #ffffff;
            border-radius: 8px;
            padding: 25px 30px;
            margin-bottom: 30px;
            border-left: 5px solid #007bff;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .section h2 {
            margin-top: 0;
            font-size: 20px;
            color: #007bff;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
            margin-bottom: 20px;
        }

        .field {
            margin-bottom: 12px;
        }

        .field strong {
            width: 220px;
            display: inline-block;
            font-weight: 600;
            color: #333;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>

    <h1>Lead Profile</h1>

    <!-- Personal Details -->
    <div class="section">
        <h2>Personal Details</h2>
        <div class="field"><strong>Full Name:</strong> Priya Sharma</div>
        <div class="field"><strong>Gender:</strong> Female</div>
        <div class="field"><strong>Age:</strong> 26</div>
        <div class="field"><strong>Marital Status:</strong> Never Married</div>
        <div class="field"><strong>Email:</strong> priya.sharma@example.com</div>
        <div class="field"><strong>Phone:</strong> +91 9876543210</div>
        <div class="field"><strong>Address:</strong> Flat 202, Sunshine Apartments, Andheri West, Mumbai, Maharashtra, India</div>
        <div class="field"><strong>Height:</strong> 5ft 4in - 162cm</div>
        <div class="field"><strong>Community:</strong> Brahmin</div>
        <div class="field"><strong>Religion:</strong> Hindu</div>
    </div>

    <!-- Career Details -->
    <div class="section">
        <h2>Career Details</h2>
        <div class="field"><strong>Work Location:</strong> Mumbai, Maharashtra, India</div>
        <div class="field"><strong>Annual Income:</strong> ₹12,00,000</div>
        <div class="field"><strong>Occupation:</strong> Software Engineer</div>
    </div>

    <!-- Education Details -->
    <div class="section">
        <h2>Education Details</h2>
        <div class="field"><strong>Education Field:</strong> Computer Science & Engineering</div>
        <div class="field"><strong>Highest Qualification:</strong> Master's Degree</div>
        <div class="field"><strong>Year of Passing:</strong> 2022</div>
        <div class="field"><strong>Specialization:</strong> Artificial Intelligence</div>
        <div class="field"><strong>Degree:</strong> M.Tech</div>
        <div class="field"><strong>School / College Name:</strong> Indian Institute of Technology, Bombay (IIT Bombay)</div>
    </div>

    <!-- Family -->
    <div class="section">
        <h2>Family</h2>
        <div class="field"><strong>Father's Name:</strong> Mr. Rakesh Sharma</div>
        <div class="field"><strong>Mother's Name:</strong> Mrs. Sunita Sharma</div>
        <div class="field"><strong>Siblings:</strong> 1 Brother</div>
        <div class="field"><strong>Family Affluence:</strong> Upper Middle Class</div>
    </div>

    <!-- Horoscope -->
    <div class="section">
        <h2>Horoscope Details</h2>
        <div class="field"><strong>Date of Birth:</strong> 15th March 1998</div>
        <div class="field"><strong>Time of Birth:</strong> 06:45 AM</div>
        <div class="field"><strong>Place of Birth:</strong> Jaipur, Rajasthan, India</div>
    </div>

    <!-- Health Status -->
    <div class="section">
        <h2>Health Status</h2>
        <div class="field"><strong>Health:</strong> No Health Problems</div>
    </div>

    <!-- Partner Preferences -->
    <div class="section">
        <h2>Preferred Partner</h2>
        <div class="field"><strong>Preferred Age Range:</strong> 27 to 32</div>
    </div>

    <!-- Footer -->
    <div class="footer">
        Generated on {{ now()->format('Y-m-d H:i') }}
    </div>

</body>
</html>
