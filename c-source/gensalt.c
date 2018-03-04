#include <stdio.h>

int main(int argc, const char * argv[]) {
 unsigned int stor;
 for(int i=0; i<4; i++) {
  stor*=16;
  char current=argv[1][i];
  if(current=='1') {
   stor+=1;
  }
  else if(current=='2') {
   stor+=2;
  }
  else if(current=='3') {
   stor+=3;
  }
  else if(current=='4') {
   stor+=4;
  }
  else if(current=='5') {
   stor+=5;
  }
  else if(current=='6') {
   stor+=6;
  }
  else if(current=='7') {
   stor+=7;
  }
  else if(current=='8') {
   stor+=8;
  }
  else if(current=='9') {
   stor+=9;
  }
  else if(current=='a') {
   stor+=10;
  }
  else if(current=='b') {
   stor+=11;
  }
  else if(current=='c') {
   stor+=12;
  }
  else if(current=='d') {
   stor+=13;
  }
  else if(current=='e') {
   stor+=14;
  }
  else if(current=='f') {
   stor+=15;
  }
 }
 stor%=4096;
 int upper=stor/64;
 int lower=stor%64;
 char values[]="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789./";
 char final[2];
 final[0]=values[upper];
 final[1]=values[lower];
 printf("%s\n",final);
 return 0;
}
