# DudeWherzMyCar
A personal Arduino project that uses Arduino, Electric IMP, GPS and other stuff to perform a location tracking and theft monitoring service

This is WIP and will be updated as and when I add new features.

Current features of the application include:
- Keeps track of the GPS location in the Mysql backend
- provides a web interface to see web logs of movements along with date, time and positions
- provides web interface to delete all the logs. (Uses PBKDF2 for authenticated purging of database)
- Provides a web endpoint where the user opens a webpage and he is redirected to Google Maps showing the last location of the device.
- Provides a monitoring system where in case the car moves out of a specified last radius, an automated SMS is sent to the user device indicating a possibility of the car being stolen :D (WIP: pending adding Twilio code)
