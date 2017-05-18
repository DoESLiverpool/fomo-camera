import time
import datetime
from picamera import PiCamera
from neopixel import *

# LED strip configuration:
LED_COUNT   = 8      # Number of LED pixels.
LED_PIN     = 18      # GPIO pin connected to the pixels (must support PWM!).
LED_FREQ_HZ = 800000  # LED signal frequency in hertz (usually 800khz)
LED_DMA     = 5       # DMA channel to use for generating signal (try 5)
LED_INVERT  = False   # True to invert the signal (when using NPN transistor level shift)

def countdown(strip, color, wait_ms=500):
	for i in range(strip.numPixels()):
		strip.setPixelColor(i, color)
		strip.show()
		time.sleep(wait_ms/1000.0)

def setAll(strip, color):
	for i in range(strip.numPixels()):
		strip.setPixelColor(i, color)
	strip.show()

def flashAll(strip, color, wait_ms=500):
	for j in range(10):
		if (j % 2 == 0):
			setAll(strip, Color(0, 0, 0))
		else:
			setAll(strip, Color(0, 255, 0))
		strip.show()
		time.sleep(wait_ms/1000.0)



#Create camera object
camera = PiCamera()
camera.resolution = (1024, 768)

# Create NeoPixel object with appropriate configuration.
strip = Adafruit_NeoPixel(LED_COUNT, LED_PIN, LED_FREQ_HZ, LED_DMA, LED_INVERT)
# Intialize the library (must be called once before other functions).
strip.begin()
strip.setBrightness(25)

#Inital countdown warning
countdown(strip, Color(0, 255, 0), 1000)

#warm up camera
camera.start_preview()

#Flash warning that photo is about to be taken
flashAll(strip, Color(0,255,0), 500)

#Change strip color to indicate photo is being taken
setAll(strip, Color(255, 0, 0))

#Take picture
camera.capture('vivian/%s.jpg' % (datetime.datetime.now().strftime("%H:%M:00")))

#Turn off all pixels
setAll(strip, Color(0, 0, 0))

time.sleep(17)

#Inital countdown warning
countdown(strip, Color(0, 255, 0), 1000)

#warm up camera
camera.start_preview()

#Flash warning that photo is about to be taken
flashAll(strip, Color(0,255,0), 500)

#Change strip color to indicate photo is being taken
setAll(strip, Color(255, 0, 0))

#Take picture
camera.capture('vivian/%s.jpg' % (datetime.datetime.now().strftime("%H:%M:30")))
time.sleep(1)

#Turn off all pixels
setAll(strip, Color(0, 0, 0))

camera.close()
