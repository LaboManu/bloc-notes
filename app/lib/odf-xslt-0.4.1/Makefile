PACKAGE = odf-xslt
VERSION = 0.4.1

FILES = odf-xslt.php

BIN = odfxsltproc

DOCS  = README \
	INSTALL \
	COPYING \
	AUTHORS \
	NEWS \
	ChangeLog

DESTDIR =
FILEDIR = $(DESTDIR)/usr/local/share/php/$(PACKAGE)
BINDIR = $(DESTDIR)/usr/bin
DOCDIR  = $(DESTDIR)/usr/local/share/doc/$(PACKAGE)

all:
	TARGETS=`for FILE in $(FILES); do \
		if test -f $$FILE.in; then echo -n "$$FILE "; fi; \
	done`; \
	for FILE in $$TARGETS; do \
		sed 's/@VERSION@/$(VERSION)/g' $$FILE.in > $$FILE; \
	done

install:
	install -d -o root -m 755 $(FILEDIR)
	install -o root -m 644 $(FILES) $(FILEDIR)
	install -o root -m 755 $(BIN) $(BINDIR)
	install -d $(DOCDIR)
	install -o root -m 644 $(DOCS) $(DOCDIR)

uninstall:
	rm -f $(FILEDIR)/*
	rmdir $(FILEDIR)
	rm -f $(BINDIR)/$(BIN)
	rm -f $(DOCDIR)/*
	rmdir $(DOCDIR)

dist: all
	-rm -f $(PACKAGE)-$(VERSION).tar.gz
	mkdir $(PACKAGE)-$(VERSION)
	for FILE in $(FILES) $(BIN) $(DOCS) Makefile; do cp $$FILE $(PACKAGE)-$(VERSION)/$$FILE; done
	tar -czf $(PACKAGE)-$(VERSION).tar.gz $(PACKAGE)-$(VERSION)
	-rm -rf $(PACKAGE)-$(VERSION)

clean:
	TARGETS=`for FILE in $(FILES); do \
		if test -f $$FILE.in; then echo -n "$$FILE "; fi; \
	done`; \
	for FILE in $$TARGETS; do \
		rm -f $$FILE; \
	done
