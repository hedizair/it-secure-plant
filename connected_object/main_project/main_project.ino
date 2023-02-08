/**
 * BasicHTTPClient.ino
 *
 *  Created on: 24.05.2015
 *
 */

#include <Arduino.h>
#include <Wire.h>
#include <WiFi.h>
#include <WiFiMulti.h>
#include <HTTPClient.h>
#include "time.h"

#define USE_SERIAL Serial

#ifdef ARDUINO_SAMD_VARIANT_COMPLIANCE
#define SERIAL SerialUSB
#else
#define SERIAL Serial
#endif
 
unsigned char low_data[8] = {0};
unsigned char high_data[12] = {0};
 
 
#define NO_TOUCH       0xFE
#define THRESHOLD      100
#define ATTINY1_HIGH_ADDR   0x78
#define ATTINY2_LOW_ADDR   0x77
 


const char* ntpServer = "pool.ntp.org";
const long  gmtOffset_sec = 3600 * 1;
const int   daylightOffset_sec = 3600 * 0;

WiFiMulti wifiMulti;


void setup() {

    USE_SERIAL.begin(115200);

    USE_SERIAL.println();
    USE_SERIAL.println();
    USE_SERIAL.println();

    for(uint8_t t = 4; t > 0; t--) {
        USE_SERIAL.printf("[SETUP] WAIT %d...\n", t);
        USE_SERIAL.flush();
        delay(1000);
    }

    wifiMulti.addAP("...", "YOSHA!!!!!");
    configTime(gmtOffset_sec, daylightOffset_sec, ntpServer);
    Wire.begin(); // Start water level sensor
}

void loop() {
    
    
    if((wifiMulti.run() == WL_CONNECTED)) {
      postWaterLevel();
    }

    delay(5000);
}

/*********** API QUERY *************/

void sendDataToApi(String json, char* serverName){
  HTTPClient http;
  WiFiClient client;

  http.begin(client, serverName);
  
  http.addHeader("Content-Type", "application/json");
  String httpRequestData = json;
  int httpResponseCode = http.POST(httpRequestData);

  Serial.print("HTTP Response code: ");
  Serial.println(httpResponseCode);
    

  http.end();

}

void postWaterLevel(){
  char* serverName = "http://192.168.43.174:8444/api/water_levels";
  char waterLevel[5];

  check(waterLevel);

  char time[20];
  getLocalTime(time);


  String waterLevelString = waterLevel;
  String timeString = time;

  String httpRequestData = "{\"level\":"+ waterLevelString + ",\"date\":\""+ timeString + "\"}";
  Serial.println(httpRequestData);  
  sendDataToApi(httpRequestData, serverName);
}

void getLocalTime(char* timeToSet){
    struct tm timeinfo;
    if (!getLocalTime(&timeinfo)) {
      Serial.println("Failed to obtain time");
    }
 
    char time[20];
  
    strftime(time,20, "%Y-%m-%d %H:%M:%S", &timeinfo);

    for(int i=0; i < 20; ++i){
      timeToSet[i] = time[i];
    }
}


/**************************************/

/*****WATER LEVEL SENSOR*****/

void getHigh12SectionValue(void)
{
  memset(high_data, 0, sizeof(high_data));
  Wire.requestFrom(ATTINY1_HIGH_ADDR, 12);
  while (12 != Wire.available());
 
  for (int i = 0; i < 12; i++) {
    high_data[i] = Wire.read();
  }
  delay(10);
}

void getLow8SectionValue(void)
{
  memset(low_data, 0, sizeof(low_data));
  Wire.requestFrom(ATTINY2_LOW_ADDR, 8);
  while (8 != Wire.available());
 
  for (int i = 0; i < 8 ; i++) {
    low_data[i] = Wire.read(); // receive a byte as character
  }
  delay(10);
}


void check(char* waterLevel)
{
  int sensorvalue_min = 250;
  int sensorvalue_max = 255;
  int low_count = 0;
  int high_count = 0;
  
  uint32_t touch_val = 0;
  int trig_section = 0;
  low_count = 0;
  high_count = 0;
  getLow8SectionValue();
  getHigh12SectionValue();

  for (int i = 0; i < 8; i++)
  {

    if (low_data[i] >= sensorvalue_min && low_data[i] <= sensorvalue_max)
    {
      low_count++;
    }
    if (low_count == 8)
    {
      Serial.print("      ");
      Serial.print("PASS");
    }
  }


  for (int i = 0; i < 12; i++)
  {


    if (high_data[i] >= sensorvalue_min && high_data[i] <= sensorvalue_max)
    {
      high_count++;
    }
    if (high_count == 12)
    {
      Serial.print("      ");
      Serial.print("PASS");
    }
  }


  for (int i = 0 ; i < 8; i++) {
    if (low_data[i] > THRESHOLD) {
      touch_val |= 1 << i;

    }
  }
  for (int i = 0 ; i < 12; i++) {
    if (high_data[i] > THRESHOLD) {
      touch_val |= (uint32_t)1 << (8 + i);
    }
  }

  while (touch_val & 0x01)
  {
    trig_section++;
    touch_val >>= 1;
  }
  /*SERIAL.print("water level = ");
  SERIAL.print(trig_section * 5);
  SERIAL.println("% ");
  SERIAL.println(" ");
  SERIAL.println("*********************************************************");*/

  itoa(trig_section * 5, waterLevel, 10);
  
  
}
 
/******************************/


