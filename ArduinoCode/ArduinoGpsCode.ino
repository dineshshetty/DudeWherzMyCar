//Arduino code:

#include <TinyGPS++.h>
#include <SoftwareSerial.h>
#include<stdlib.h>
#include <Time.h>

/*
 This example uses software serial and the TinyGPS++ library t
 Based on TinyGPSPlus/DeviceExample.ino by Mikal Hart
but is modified by dineshshetty as required.
*/

// Arduino Pins for communication
int RXPin = 2;
int IMP_TXPin = 3;

// GPS unit used for demo: https://www.sparkfun.com/products/12751
// uses 4800 as default baud rate
int GPSBaud = 4800;

//This is the GPS Object
TinyGPSPlus gps;

// This is the software serial
SoftwareSerial gpsSerial(RXPin, IMP_TXPin);

void setup()
{
  // Arduino hardware serial set to 9600 baud rate
  Serial.begin(9600);

  // GPS software serial port set at the default baud rate
  gpsSerial.begin(GPSBaud);
 // impSerial.begin(GPSBaud);
 
  Serial.println(F("DeviceExample.ino"));
  Serial.println(F("A simple demonstration of TinyGPS++ with an attached GPS module"));
  Serial.print(F("Testing TinyGPS++ library v. ")); Serial.println(TinyGPSPlus::libraryVersion());
  Serial.println(F("by Mikal Hart"));
  Serial.println();
 
 
 
}

void loop()
{

  while (gpsSerial.available() > 0)
    if (gps.encode(gpsSerial.read()))
      displayInfo();

  // If 5000 milliseconds passed since last character
 // show an error
  if (millis() > 5000 && gps.charsProcessed() < 10)
  {
    Serial.println(F("No GPS detected"));
    while(true);
  }
}

void displayInfo()
{
  if (gps.location.isValid())
  {
   char Strgpslat_c[15]; char Strgpslon_c[15];
    dtostrf(gps.location.lat(), 0, 6, Strgpslat_c);
    dtostrf(gps.location.lng(), 0, 6, Strgpslon_c);
    gpsSerial.println(String(Strgpslat_c) +","+ String(Strgpslon_c)+"||"+gps.date.year()+"-"+gps.date.month()+"-"+gps.date.day()+"||"+String(gps.time.hour())+":"+(gps.time.minute())+":"+gps.time.second()); 
    delay(1000);
  }
  else
  {
    Serial.print(F("INVALID"));
  }
  Serial.println();
}

