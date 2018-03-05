//
//  main.c
//  typing_quirks
//
//  Created by Sam Anguiano on 3/4/18.
//  Copyright © 2018 dodecaplexor. All rights reserved.
//

#include <stdio.h>
#include <stdlib.h>
#include <string.h>

char toLower(char chr) {
	char result=chr;
	if((int)chr>=65 && (int)chr<=90) {
		result=(char)((int)chr+32);
	}
	return result;
}

typedef struct {
    char typed[11];
    int typedlen;
    char result[11];
    int resultlen;
} pattern;

pattern patterns[11];
int activepatterns=0;

void fillmine() {
    activepatterns=7;
    pattern ndpat={.typedlen=3,.typed="and",.result="&",.resultlen=2};
    pattern atpat={.typedlen=2,.typed="at",.result="@",.resultlen=1};
    pattern aspat={.typedlen=2,.typed="as",.result="42",.resultlen=2};
    pattern apat={.typedlen=1,.typed="a",.result="/-\\",.resultlen=3};
    pattern spat={.typedlen=1,.typed="s",.result="§",.resultlen=2};
    pattern mpat={.typedlen=1,.typed="m",.result="/\\/\\",.resultlen=4};
    pattern upat={.typedlen=1,.typed="u",.result="U",.resultlen=1};
    patterns[0]=ndpat;
    patterns[1]=atpat;
    patterns[2]=aspat;
    patterns[3]=apat;
    patterns[4]=spat;
    patterns[5]=mpat;
    patterns[6]=upat;
}

void readtable() {
	FILE *fptr;
	char chr;
	int doing=1;
	fptr = fopen("quirk_table.txt", "r");
	for(int line=0; line<11; line++) {
		if(doing==0) {
			break;
		}
		char datastuff[2][11];
		int datalen[2]={0,0};
		int part=0;
		int mode=0;
		for(int i=0; i<30; i++) {
			chr = fgetc(fptr);
			//printf("%c",chr);
			if(i==0) {
				if(chr=='E') {
					doing=0;
					break;
				}
			}
			else {
				if(mode==0) {
					if(chr=='"') {
						mode=1;
					}
					else if(chr=='=') {
						part++;
					}
					else if(chr=='\n') {
						break;
					}
				}
				else if(mode==1) {
					if(chr=='\\') {
						mode=2;
					}
					else if(chr=='"') {
						mode=0;
					}
					else {
						datastuff[part][datalen[part]]=chr;
						datalen[part]++;
					}
				}
				else {
					datastuff[part][datalen[part]]=chr;
					datalen[part]++;
					mode=1;
				}
			}
		}
		patterns[line].typedlen=datalen[0];
		patterns[line].resultlen=datalen[1];
		for(int j=0; j<datalen[0]; j++) {
			patterns[line].typed[j]=datastuff[0][j];
		}
		for(int j=0; j<datalen[1]; j++) {
			patterns[line].result[j]=datastuff[1][j];
		}
		activepatterns++;
		//printf("pattern %i: .typed=\"%s\" .typedlen=%i .result=%s .resultlen=%i \n",line,patterns[line].typed,patterns[line].typedlen,patterns[line].result,patterns[line].resultlen);
	}
	activepatterns--;
	fclose(fptr);
}

int testpattern(char* tobetested, char* pat, int len) {
    int match=1;
    for(int i=0; i<len; i++) {
        if(tobetested[i]!=pat[i]) {
            match=0;
            break;
        }
    }
    return match;
}
void copystr(char* target, const char* origin, int len) {
    for(int i=0; i<len; i++) {
        target[i]=origin[i];
    }
}

int main(int argc, const char * argv[]) {
    //fillmine();
	readtable();
    char currentpattern[11];
    int cpl=0;
    int typedlen=atoi(argv[2]);
    char typed[32767];
    copystr(typed, argv[1], typedlen);
    char final[32767];
    int currentlen=0;
    for(int i=0; i<activepatterns; i++) {
        for(int j=0; j<typedlen; j++) {
			//printf("%c",typed[j]);
            if(toLower(typed[j])==patterns[i].typed[cpl]) {
                currentpattern[cpl]=typed[j];
                cpl++;
            }
            else {
                for(int k=0; k<cpl; k++) {
                    final[currentlen]=currentpattern[k];
                    currentlen++;
                }
                cpl=0;
                final[currentlen]=typed[j];
                currentlen++;
            }
            if(cpl==patterns[i].typedlen) {
                for(int k=0; k<patterns[i].resultlen; k++) {
                    final[currentlen]=patterns[i].result[k];
                    currentlen++;
                }
                cpl=0;
            }
        }
		//printf("\n");
        for(int k=0; k<cpl; k++) {
            final[currentlen]=currentpattern[k];
            currentlen++;
        }
        cpl=0;
        copystr(typed, final, currentlen);
        typedlen=currentlen;
        currentlen=0;
    }
	for(int j=0; j<typedlen; j++) {
		printf("%c",typed[j]);
	}
    printf("\n");
	//printf("%i-%i, %i-%i\n",(int)'a',(int)'z',(int)'A',(int)'Z');
    return 0;
}
