#include "seeed_bme680.h"

#define IIC_ADDR  uint8_t(0x76)

Seeed_BME680 bme680(IIC_ADDR);

void setup() {
    Serial.begin(9600);
    while (!Serial);
    Serial.println("Serial start!!!");
    delay(100);
    while (!bme680.init()) {
        Serial.println("bme680 init failed ! can't find device!");
        delay(10000);
    }
}

void loop() {
    if (bme680.read_sensor_data()) {
        Serial.println("Failed to perform reading :(");
        return;
    }
    Serial.print("temperature ===>> ");
    Serial.print(bme680.sensor_result_value.temperature);
    Serial.println(" C");

    Serial.print("pressure ===>> ");
    Serial.print(bme680.sensor_result_value.pressure / 1000.0);
    Serial.println(" KPa");

    Serial.print("humidity ===>> ");
    Serial.print(bme680.sensor_result_value.humidity);
    Serial.println(" %");

    Serial.print("gas ===>> ");
    Serial.print(bme680.sensor_result_value.gas / 1000.0);
    Serial.println(" Kohms");

    Serial.println();
    Serial.println();

    delay(2000);
}

