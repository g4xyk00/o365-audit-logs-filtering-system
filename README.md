# Office 365 Audit Logs - JSON to CSV Converter
The tool converts JSON data from 'AuditData' in o365 audit logs to a new CSV file for easier analysis.

## Proof-of-Concept
Raw File Before Conversion: JSON data in the "AuditData" column
![Screenshot](https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjxWqE9c5YhVFeqPojjxtnFlvDa82WpCSa8rOffxDBfLU6hGasRr2_qlRmY8dQt8ueZxc29aV5asb980u8g0HeOAXQXHOaJ44QPb5Q5dnV_KWaUE0YIKOUYCLSv0LqPx22VuW6Jk33eggmBf3kADsDJvs-c4V9r3egwN8kFDa_twIl20NEuEH7JXQ12MY7n/s1600/Screenshot%202024-10-25%20082037.png)

Specific Audit Item Extraction and Conversion: Extracting and converting specific audit items from the JSON data into CSV format:
![Screenshot](https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEih4Md5ngjRNdXOzfOxByrhcsNYMQnNhyphenhyphentezq7mHJxN-9YVQQXu1-INb2z1cb1A8nuAmd_tCrWFFZ65GYXl1Cw_hL_uEOBbfcumSDCqAp2dr6T4EdoXDXxHoO4_JdCWnJNHcWNc5397SZmuRJ-LGsVwdW6uTZG41v8YxF8B2bKn3nuanaLOcEM9Ur1-lVEw/s1600/Screenshot%202024-10-25%20082543.png)

## Setup Instructions
#### 1. Install XAMPP
Download and install XAMPP from https://www.apachefriends.org/. Run the Apache module after installation.

#### 2. Create a Project Directory
Create a new folder named `o365` within the XAMPP `htdocs` directory (e.g., `C:\xampp\htdocs\o365`).

#### 3. Upload Audit Log CSV
Place the downloaded Office 365 audit log CSV file into the `o365` folder

#### 4. Download and Place index.php
Download the `index.php` file from GitHub and place it in the `o365` folder

#### 5. Update index.php Configuration
Open `index.php` in a text editor. Locate line 13 and replace `$PATH_LOG` with the exact filename of your audit log CSV file (e.g., `$PATH_LOG = 'your_audit_log_file.csv'`;).

#### 6. Access the Web Application
Open a web browser and navigate to `http://localhost/o365`.

#### 7. Download the Processed CSV
The processed CSV file will automatically be downloaded to your computer.
