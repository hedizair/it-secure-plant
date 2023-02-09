const int sensorPin = A0;
int sensorValue = 0;

const int pinPump = D4; 

void setup() {
    Serial.begin(9600);
    pinMode(pinLight, OUTPUT);
}

void loop() {
    sensorValue = analogRead(sensorPin);
    Serial.println(sensorValue);

    if(sensorValue < 200)
    {
      digitalWrite(pinPump, HIGH);
    }
    else 
    {
      digitalWrite(pinPump, LOW);
    }

    delay(10000);
}