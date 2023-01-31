#include <Adafruit_NeoPixel.h>
#ifdef __AVR__
 #include <avr/power.h>
#endif

#define PIN 22
#define NUMPIXELS 10

Adafruit_NeoPixel pixels(NUMPIXELS, PIN, NEO_GRB + NEO_KHZ800);

#define DELAYVAL 500

void setup() {
  #if defined(__AVR_ATtiny85__) && (F_CPU == 16000000)
    clock_prescale_set(clock_div_1);
  #endif

  pixels.begin(); 
  pixels.setBrightness(50); 
}

void loop() {
  pixels.clear();
  pixels.setPixelColor(0, pixels.Color(255, 0, 0));
  pixels.setPixelColor(1, pixels.Color(255, 0, 0));
  pixels.setPixelColor(2, pixels.Color(255,140,0));
  pixels.setPixelColor(3, pixels.Color(255,140,0));
  pixels.setPixelColor(4, pixels.Color(255,215,0));
  pixels.setPixelColor(5, pixels.Color(255,215,0));
  pixels.setPixelColor(6, pixels.Color(154,205,50));
  pixels.setPixelColor(7, pixels.Color(154,205,50));
  pixels.setPixelColor(8, pixels.Color(0, 255, 0));
  pixels.setPixelColor(9, pixels.Color(0, 255, 0));
  pixels.show();
}
