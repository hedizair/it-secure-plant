const int sensorPin = A0;
int sensorValue = 0;

const int pinPump = 15; 

void setup() {
    Serial.begin(9600);
    pinMode(pinPump, OUTPUT);
}

void loop() {
    sensorValue = analogRead(sensorPin);
    Serial.println(sensorValue);

    if(sensorValue < 200)
    {
      digitalWrite(pinPump, HIGH);
      Serial.println("HIGH");
    }
    else 
    {
      digitalWrite(pinPump, LOW);
      Serial.println("LOW");
    }

    Serial.println("");

    delay(1000);
}