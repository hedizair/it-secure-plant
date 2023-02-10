#include <Arduino.h>

#include "time.h"

#include <Wire.h>

#include <WiFi.h>
#include <HTTPClient.h>

#include <AsyncTCP.h>
#include <ESPAsyncWebServer.h>

#include <pthread.h>

#include "seeed_bme680.h"

#define IIC_ADDR  uint8_t(0x76)

Seeed_BME680 bme680(IIC_ADDR);

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

// const char* ssid = "-.-";
// const char* password = "05052002";
const char* ssid = "...";
const char* password = "YOSHA!!!!!";

const int sensorPin = 36;
int sensorValue = 0;
const int pinPump = 14; 

bool postSent = false;

AsyncWebServer server(80);


void *sendRequest(void *argHttp){
   AsyncWebServerRequest *request = (AsyncWebServerRequest*)argHttp;  
   request->send(200, "text/plain",  "Water level has been updated");    
} 


void *postWaterLevel(void *argHttp){
  postSent = false;
  //AsyncWebServerRequest *request = (AsyncWebServerRequest*)argHttp;  
  

  
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
  postSent = true;


 
}


void setup() {    
    Serial.begin(9600);



    configTime(gmtOffset_sec, daylightOffset_sec, ntpServer);

    pinMode(pinPump, OUTPUT); // Start pump

    Wire.begin(); // Start water level sensor

    while (!bme680.init()) { // Start BME sensor
        Serial.println("bme680 init failed ! can't find device!");
        delay(500);
    }

    WiFi.mode(WIFI_STA);
    WiFi.begin(ssid, password);
    while (WiFi.status() != WL_CONNECTED) {
        Serial.printf("Connexion en cours ...\n");
        delay(500);
    }
    Serial.printf("Connecté !\n");
    Serial.print("IP Address: ");
    Serial.println(WiFi.localIP());

    server.on("/water_level/refresh", HTTP_GET, [] (AsyncWebServerRequest *request) {
      pthread_t httpThread;
      pthread_create(&httpThread, NULL, postWaterLevel, (void*)&request);
      //pthread_join(httpThread, NULL);
      
      request->send(200, "text/plain",  "Water level has been updated");
    });

  

    server.on("/air_condition/refresh", HTTP_GET, [] (AsyncWebServerRequest *request) {
      pthread_t httpThread;
      pthread_create(&httpThread, NULL, postBME, NULL);
      //pthread_join(httpThread, NULL);
      
      request->send(200, "text/plain",  "Water level has been updated");
    });

   

    server.onNotFound(notFound);
    server.begin();
}

void loop() {
    sensorValue = analogRead(sensorPin);
    //Serial.println(sensorValue);

    if(sensorValue < 200)
    {
      // postBME();
      digitalWrite(pinPump, HIGH);
      //Serial.println("HIGH");
    }
    else 
    {
      digitalWrite(pinPump, LOW);
      //Serial.println("LOW");
    } 

    delay(1000);
}

/*********** API QUERY *************/

void notFound(AsyncWebServerRequest *request) {
    request->send(404, "text/plain", "Not found");
}

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

/*********** WATER LEVEL SENSOR *************/

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
 
/*********** BME SENSOR *************/

void *postBME(void *arg){
  char* serverName = "http://192.168.43.174:8888/api/air_conditions";
  char temperature[5];
  char humidity[5];
  char pressure[5];

  bme(temperature, humidity, pressure);

  char time[20];
  getLocalTime(time);

  String temperatureString = temperature;
  String humidityString = humidity;
  String pressureString = pressure;
  String areaString = "1";
  String timeString = time;

  String httpRequestData = "{\"temperature\":"+ temperatureString + ",\"humidity\":\""+ humidityString + ",\"atmospheric_pressure\":\""+ pressureString + ",\"area\":\""+ areaString + ",\"date\":\""+ timeString + "\"}";
  Serial.println(httpRequestData);
  sendDataToApi(httpRequestData, serverName);
}

void bme(char* temperature, char* humidity, char* pressure)
{
  if (bme680.read_sensor_data()) {
    Serial.println("Failed to perform reading :(");
    return;
  }

  double t = bme680.sensor_result_value.temperature;
  Serial.println(t);
  Serial.print(" C");

  double h = bme680.sensor_result_value.humidity;
  Serial.println(h);
  Serial.print(" %");

  double p = bme680.sensor_result_value.pressure / 100.0;
  Serial.println(p);
  Serial.print(" HPa");

  itoa(t, temperature, 10);
  itoa(h, humidity, 10);
  itoa(p, pressure, 10);
}

