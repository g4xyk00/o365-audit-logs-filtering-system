# Office 365 Audit Logs - JSON to CSV Converter
The tool converts JSON data from 'AuditData' in o365 audit logs to a new CSV file for easier analysis.

## Setup Instructions
1. Install XAMPP
Download and install XAMPP from https://www.apachefriends.org/.

3. Create a Project Directory
Create a new folder named "o365" within the XAMPP "htdocs" directory (e.g., C:\xampp\htdocs\o365).

3. Upload Audit Log CSV
Place the downloaded Office 365 audit log CSV file into the "o365" folder

4. Download and Place index.php
Download the "index.php" file from GitHub and place it in the "o365" folder

5. Update index.php Configuration
Open "index.php" in a text editor. Locate line 13 and replace $PATH_LOG with the exact filename of your audit log CSV file (e.g., $PATH_LOG = 'your_audit_log_file.csv';).

6. Access the Web Application
Open a web browser and navigate to http://localhost/o365.

7. Download the Processed CSV
The processed CSV file will automatically be downloaded to your computer.
