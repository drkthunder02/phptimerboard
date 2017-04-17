Instructions for Installation
1.)  Download all of the github installation
2.)  Enter into the timerboard directory
3.)  Import the sql database tables from sql/database.sql
4.)  Register the application at http://developers.eveonline.com
5.)  When presented with a client id and secret code modify the ini file functions/configuration/config.ini
6.)  Modify the database parameters in /functions/database/dbopen.php
7.)  Setup either Apache2 or Nginx.  This guide doesn't cover this part.
8.) Enter in the information being requested.  Use the account you wish to have as the SuperAdmin.  No one can delete a SuperAdmin unless you modify the database.
9.) Your timerboard should be ready to use now

Future Updates:
- Scheduled Task to retrieve all alliances and corporations from ESI.  This wasn't included in this build as the program can run for several hours retrieving this
- information.

- Utilize ESI for further functionality to include automated timers if CCP gives access to those end points.

- Retool main page to include ajax calls to automatically reload page every minute or so.
