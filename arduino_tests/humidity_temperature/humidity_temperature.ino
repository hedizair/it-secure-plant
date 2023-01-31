#include <Adafruit_SH110X.h>
#include "DHT.h"

Adafruit_SH1107 display = Adafruit_SH1107(64, 128, &Wire);

#define DHTPIN 16 //UART
#define DHTTYPE DHT22 
DHT dht(DHTPIN, DHTTYPE);

float humidity = 0;
float temperature = 0;

void setup() {
  Serial.begin(9600);
  Serial.println();
  
  dht.begin();
    
  Serial.println("128x64 OLED FeatherWing test");
  delay(250);
  display.begin(0x3C, true); // Address 0x3C default

  Serial.println("OLED begun");

  display.display();
  delay(1000);

  display.clearDisplay();
  display.display();

  display.setRotation(1);
}

void loop() {
  float h = dht.readHumidity();
  float t = dht.readTemperature();

  if (isnan(h) || isnan(t)) {
    Serial.println(F("Failed to read from DHT sensor!"));
    return;
  }

  if(humidity != h || temperature != t)
  {
    humidity = h;
    temperature = t;

    display.clearDisplay();
    display.display();
    
    display.setTextSize(1);
    display.setTextColor(SH110X_WHITE);
    display.setCursor(0, 0);


    display.print("Humidite : ");
    display.print(h);  
    display.println("%");  
    display.print("Temperature : ");
    display.print(t);
    display.print("°");   

    display.display();
  }
}
