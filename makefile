# Build/conversion commands

MD=@mkdir
CP=@cp
XT=@xml2txt sabcmd
DAT2TXT=@datutil -X -D -k -f delimited
MAP2TXT=@map2txt
INFO2TXT=@info2txt
CAT2TXT=@cat2txt
LD=@load_tables.sh


# Main directories

DATA_DIR=data
XSL_DIR=xsl
ifeq ($(HOSTNAME), gamma.publichostserver.com)
TXT_DIR=../www/caesar/txt
SQL_DIR=../www/caesar/sql
else
TXT_DIR=www/txt
SQL_DIR=www/sql
endif


# Author objects

AUTHOR_DIR=authors

AUTHOR_OBJS=$(patsubst $(DATA_DIR)/$(AUTHOR_DIR)/%.xml, $(TXT_DIR)/$(AUTHOR_DIR)/%.txt, \
	$(wildcard $(DATA_DIR)/$(AUTHOR_DIR)/*.xml))

ifeq ($(AUTHOR_OBJS),)
AUTHOR_OBJS=$(wildcard $(TXT_DIR)/$(AUTHOR_DIR)/*.txt)
endif

AUTHOR_DIRS=$(sort $(dir $(AUTHOR_OBJS)))

AUTHOR_TAG=$(TXT_DIR)/$(AUTHOR_DIR).tag


# Emulator objects

EMULATOR_DIR=emus

EMULATOR_OBJS=$(patsubst $(DATA_DIR)/$(EMULATOR_DIR)/%.xml, $(TXT_DIR)/$(EMULATOR_DIR)/%.txt, \
	$(wildcard $(DATA_DIR)/$(EMULATOR_DIR)/*.xml $(DATA_DIR)/$(EMULATOR_DIR)/*/*.xml))

ifeq ($(EMULATOR_OBJS),)
EMULATOR_OBJS=$(wildcard $(TXT_DIR)/$(EMULATOR_DIR)/*.txt $(TXT_DIR)/$(EMULATOR_DIR)/*/*.txt)
endif

EMULATOR_DIRS=$(sort $(dir $(EMULATOR_OBJS)))

EMULATOR_TAG=$(TXT_DIR)/$(EMULATOR_DIR).tag


# Library objects

LIBRARY_DIR=libs

LIBRARY_OBJS=$(patsubst $(DATA_DIR)/$(LIBRARY_DIR)/%.xml, $(TXT_DIR)/$(LIBRARY_DIR)/%.txt, \
	$(wildcard $(DATA_DIR)/$(LIBRARY_DIR)/*.xml $(DATA_DIR)/$(LIBRARY_DIR)/*/*.xml))

ifeq ($(LIBRARY_OBJS),)
LIBRARY_OBJS=$(wildcard $(TXT_DIR)/$(LIBRARY_DIR)/*.txt $(TXT_DIR)/$(LIBRARY_DIR)/*/*.txt)
endif

LIBRARY_DIRS=$(sort $(dir $(LIBRARY_OBJS)))

LIBRARY_TAG=$(TXT_DIR)/$(LIBRARY_DIR).tag


# Tool objects

TOOL_DIR=tools

TOOL_OBJS=$(patsubst $(DATA_DIR)/$(TOOL_DIR)/%.xml, $(TXT_DIR)/$(TOOL_DIR)/%.txt, \
	$(wildcard $(DATA_DIR)/$(TOOL_DIR)/*.xml $(DATA_DIR)/$(TOOL_DIR)/*/*.xml))

ifeq ($(TOOL_OBJS),)
TOOL_OBJS=$(wildcard $(TXT_DIR)/$(TOOL_DIR)/*.txt $(TXT_DIR)/$(TOOL_DIR)/*/*.txt)
endif

TOOL_DIRS=$(sort $(dir $(TOOL_OBJS)))

TOOL_TAG=$(TXT_DIR)/$(TOOL_DIR).tag


# Game objects

GAME_DIR=games

GAME_OBJS=$(filter-out $(TXT_DIR)/$(GAME_DIR)/logs%, $(patsubst $(DATA_DIR)/$(GAME_DIR)/%.dat, $(TXT_DIR)/$(GAME_DIR)/%.dat, \
	$(wildcard $(DATA_DIR)/$(GAME_DIR)/nonmame.dat $(DATA_DIR)/$(GAME_DIR)/*/*.dat)) \
	$(patsubst $(DATA_DIR)/$(GAME_DIR)/%.map, $(TXT_DIR)/$(GAME_DIR)/%.txt, $(wildcard $(DATA_DIR)/$(GAME_DIR)/*/*.map)))

ifeq ($(GAME_OBJS),)
GAME_OBJS=$(wildcard $(TXT_DIR)/$(GAME_DIR)/nonmame.dat $(TXT_DIR)/$(GAME_DIR)/*/*.dat $(TXT_DIR)/$(GAME_DIR)/*/*.txt)
endif

GAME_DIRS=$(sort $(dir $(GAME_OBJS)))

GAME_TAG=$(TXT_DIR)/$(GAME_DIR).tag


# File objects

FILE_DIR=files

FILE_OBJS=$(patsubst $(DATA_DIR)/$(FILE_DIR)/%.txt, $(TXT_DIR)/$(FILE_DIR)/%.txt, $(wildcard $(DATA_DIR)/$(FILE_DIR)/*.txt))

ifeq ($(FILE_OBJS),)
FILE_OBJS=$(wildcard $(TXT_DIR)/$(FILE_DIR)/*.txt)
endif

FILE_DIRS=$(sort $(dir $(FILE_OBJS)))

FILE_TAG=$(TXT_DIR)/$(FILE_DIR).tag


# Misc objects

MISC_DIR=misc

MISC_OBJS=$(patsubst $(DATA_DIR)/$(MISC_DIR)/%.dat, $(TXT_DIR)/$(MISC_DIR)/%.txt, $(wildcard $(DATA_DIR)/$(MISC_DIR)/*.dat)) \
	  $(patsubst $(DATA_DIR)/$(MISC_DIR)/%.ini, $(TXT_DIR)/$(MISC_DIR)/%.txt, $(wildcard $(DATA_DIR)/$(MISC_DIR)/*.ini)) \
	  $(patsubst $(DATA_DIR)/$(MISC_DIR)/%.txt, $(TXT_DIR)/$(MISC_DIR)/%.txt, $(wildcard $(DATA_DIR)/$(MISC_DIR)/*.txt)) \

ifeq ($(MISC_OBJS),)
MISC_OBJS=$(wildcard $(TXT_DIR)/$(MISC_DIR)/*.txt)
endif

MISC_DIRS=$(sort $(dir $(MISC_OBJS)))

MISC_TAG=$(TXT_DIR)/$(MISC_DIR).tag


# Main rules ('make txt' can be used to do everything except the loading)

all: maketree $(AUTHOR_TAG) $(EMULATOR_TAG) $(LIBRARY_TAG) $(TOOL_TAG) $(GAME_TAG) $(FILE_TAG) $(MISC_TAG)

txt: maketree $(AUTHOR_OBJS) $(EMULATOR_OBJS) $(LIBRARY_OBJS) $(TOOL_OBJS) $(GAME_OBJS) $(FILE_OBJS) $(MISC_OBJS)


# Directory tree creation

TXT_DIRS=$(TXT_DIR) $(AUTHOR_DIRS) $(EMULATOR_DIRS) $(LIBRARY_DIRS) $(TOOL_DIRS) $(GAME_DIRS) $(FILE_DIRS) $(MISC_DIRS)

maketree: $(sort $(TXT_DIRS))

$(sort $(TXT_DIRS)):
	@echo "Creating directory $@..."
	$(MD) $@


# Directory tree removal

clean:
	@echo "Removing 'txt' directory..."
	@rm -fr $(TXT_DIR)


# Author rules

AUTHOR_XSL=$(XSL_DIR)/author_txt.xsl

$(TXT_DIR)/$(AUTHOR_DIR)/%.txt: $(DATA_DIR)/$(AUTHOR_DIR)/%.xml $(AUTHOR_XSL)
	@echo "Generating $@"...
	$(XT) $(AUTHOR_XSL) $< $@ >/dev/null

$(AUTHOR_TAG): $(AUTHOR_OBJS)
	$(LD) $(TXT_DIR) $(AUTHOR_DIR)


# Emulator rules

EMULATOR_XSL=$(XSL_DIR)/emu_txt.xsl

$(TXT_DIR)/$(EMULATOR_DIR)/%.txt: $(DATA_DIR)/$(EMULATOR_DIR)/%.xml $(EMULATOR_XSL)
	@echo "Generating $@"...
	$(XT) $(EMULATOR_XSL) $< $@ >/dev/null

$(EMULATOR_TAG): $(EMULATOR_OBJS)
	$(LD) $(TXT_DIR) $(EMULATOR_DIR)


# Library rules

LIBRARY_XSL=$(XSL_DIR)/lib_txt.xsl

$(TXT_DIR)/$(LIBRARY_DIR)/%.txt: $(DATA_DIR)/$(LIBRARY_DIR)/%.xml $(LIBRARY_XSL)
	@echo "Generating $@"...
	$(XT) $(LIBRARY_XSL) $< $@ >/dev/null

$(LIBRARY_TAG): $(LIBRARY_OBJS)
	$(LD) $(TXT_DIR) $(LIBRARY_DIR)


# Tool rules

TOOL_XSL=$(XSL_DIR)/tool_txt.xsl

$(TXT_DIR)/$(TOOL_DIR)/%.txt: $(DATA_DIR)/$(TOOL_DIR)/%.xml $(TOOL_XSL)
	@echo "Generating $@"...
	$(XT) $(TOOL_XSL) $< $@ >/dev/null

$(TOOL_TAG): $(TOOL_OBJS)
	$(LD) $(TXT_DIR) $(TOOL_DIR)


# Game rules

$(TXT_DIR)/$(GAME_DIR)/%.dat: $(DATA_DIR)/$(GAME_DIR)/%.dat
	@echo "Generating $(subst ?, ,$@)"...
	$(DAT2TXT) -o "$(subst ?, ,$@)" "$(subst ?, ,$<)" >nul
	@rm -f datutil.log

$(TXT_DIR)/$(GAME_DIR)/%.txt: $(DATA_DIR)/$(GAME_DIR)/%.map
	@echo "Generating $(subst ?, ,$@)"...
	$(MAP2TXT) "$(subst ?, ,$<)" "$(subst ?, ,$@)" >nul

$(GAME_TAG): $(GAME_OBJS)
	$(LD) $(TXT_DIR) $(GAME_DIR)


# File rules

$(TXT_DIR)/$(FILE_DIR)/%.txt: $(DATA_DIR)/$(FILE_DIR)/%.txt
	@echo "Generating $@"...
	$(CP) $< $@

$(FILE_TAG): $(FILE_OBJS)
	$(LD) $(TXT_DIR) $(FILE_DIR)


# Misc rules

$(TXT_DIR)/$(MISC_DIR)/history.txt: $(DATA_DIR)/$(MISC_DIR)/history.dat
	@echo "Generating $@"...
	$(INFO2TXT) history $< $@

$(TXT_DIR)/$(MISC_DIR)/mameinfo.txt: $(DATA_DIR)/$(MISC_DIR)/mameinfo.dat
	@echo "Generating $@"...
	$(INFO2TXT) mameinfo $< $@

$(TXT_DIR)/$(MISC_DIR)/catver.txt: $(DATA_DIR)/$(MISC_DIR)/catver.ini
	@echo "Generating $@"...
	$(CAT2TXT) $< $@

$(TXT_DIR)/$(MISC_DIR)/%.txt: $(DATA_DIR)/$(MISC_DIR)/%.txt
	@echo "Generating $@"...
	$(CP) $< $@

$(MISC_TAG): $(MISC_OBJS)
	$(LD) $(TXT_DIR) $(MISC_DIR)

