import os
import ftplib

#simple ftp uploader for fomocam
#Connects to remote server and uploads all jpgs in piDir
#fomocam.co.uk

#image directory
piDir = "/home/pi/mo"
serverDir = "/public_html/mo/"

#Connect to ftp server
ftp = ftplib.FTP(FTPSERVER)
ftp.login(USER, PASSWORD)

#Change working directory on server
ftp.cwd(serverDir) 

#Loop on all files in piDir
for filename in os.listdir(piDir):
	if filename.endswith('.jpg'):
		curFname = os.path.join(piDir, filename)
		#Upload file to serverDir
		ftp.storbinary('STOR ' + filename, open(curFname, 'rb'))
		#Move local copy of file to /uploaded
		os.rename(curFname, os.path.join(piDir, 'uploaded/' + filename))

#Close ftp connection
ftp.quit()
