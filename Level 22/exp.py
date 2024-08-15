def one(s):
    return "[~" + "".join(f"%{hex(255 - ord(c))[2:].upper()}" for c in s) + "][!%FF]("

while 1:
    a = input("").rstrip(")")
    aa = a.split("(")
    s = "".join(one(each) for each in aa[:-1])
    s += ")" * (len(aa) - 1) + ";"
    print(s)