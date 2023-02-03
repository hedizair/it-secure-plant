const int pinLight = A0;                // light sensor connect to A0
 
void setup()
{
  pinMode(pinLight, OUTPUT);
}
 
void loop()
{
  digitalWrite(pinLight, HIGH);
  delay(10000);
  digitalWrite(pinLight, LOW);
  delay(10000);
}