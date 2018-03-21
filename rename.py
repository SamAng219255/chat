import sys

sf=open(sys.argv[1],'r')
str=sf.read()
sf.close()

str=str.replace('page=10','p=browse')
str=str.replace('page=8','p=chat')
str=str.replace('page=2','p=general')
str=str.replace('page=1','p=login')
str=str.replace('page=0','p=home')

ef=open(sys.argv[1],'w')
ef.write(str)
ef.close()
#print(str)
