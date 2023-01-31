const int pinLight = A0;                // light sensor connect to A0
 
void setup()
{
    Serial.begin(9600);
}
 
 
void loop()
{
  Serial.println(analogRead(pinLight));
  delay(20);
}