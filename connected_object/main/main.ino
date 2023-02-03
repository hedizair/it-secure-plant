#include <WiFi.h>
#include <HTTPClient.h>
#include <Arduino_JSON.h>


const char* ssid = "DrMundo";
const char* password = "olafessdroite";
const int pinLight = A0;   
const char* apitest = "https://euw1.api.riotgames.com/lol/summoner/v4/summoners/by-name/Boinananas?api_key=RGAPI-e90613ab-c3d2-4ec5-bc14-0ed45ffc6e16";
const char* serverName = "192.168.227.80";

String sensorReadings;

void setup() {
  Serial.begin(9600);
    delay(1000);

    WiFi.mode(WIFI_STA); //Optional
    WiFi.begin(ssid, password);
    Serial.println("\nConnecting");
   

    while(WiFi.status() != WL_CONNECTED){
        Serial.print(".");
        delay(100);
    }
    
    Serial.println("\nConnected to the WiFi network");
    Serial.print("Local ESP32 IP: ");
    Serial.println(WiFi.localIP()); 



}

void loop() {
  // Seri al.println(analogRead(pinLight));
    //Send an HTTP POST request every 10 seconds
 
    //Check WiFi connection status
    delay(2000);
    if(WiFi.status()== WL_CONNECTED){

     HTTPClient http;

      String serverPath = serverName;
      
      // Your Domain name with URL path or IP address with path
      http.begin(serverPath.c_str());
      
      // If you need Node-RED/server authentication, insert user and password below
      //http.setAuthorization("REPLACE_WITH_SERVER_USERNAME", "REPLACE_WITH_SERVER_PASSWORD");
      
      // Send HTTP GET request
      int httpResponseCode = http.GET();
      
      if (httpResponseCode>0) {
        Serial.print("HTTP Response code: ");
        Serial.println(httpResponseCode);
        String payload = http.getString();
        Serial.println(payload);
      }
      else {
        Serial.print("Error code: ");
        Serial.println(httpResponseCode);
      }
      // Free resources
      http.end();
   
    }
    else {
      Serial.println("WiFi Disconnected");
    }

}
