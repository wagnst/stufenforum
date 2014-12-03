-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Erstellungszeit: 22. November 2009 um 15:43
-- Server Version: 5.0.41
-- PHP-Version: 5.2.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Datenbank: `stufenseite`
-- 

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `foren_beitraege`
-- 

CREATE TABLE `foren_beitraege` (
  `Beitrags_ID` int(6) NOT NULL auto_increment,
  `Themen_ID` int(4) NOT NULL,
  `Zeit` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `Poster_ID` int(4) NOT NULL,
  `Beitrag` text character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`Beitrags_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=28 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `foren_themen`
-- 

CREATE TABLE `foren_themen` (
  `Themen_ID` int(4) NOT NULL auto_increment,
  `Gruppen_ID` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL,
  `Thema` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  `Startzeitpunkt` timestamp NOT NULL default '0000-00-00 00:00:00',
  `letzter_Beitrag_Zeit` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `letzter_Beitrag_ID` int(5) NOT NULL,
  `Anzahl_Beitraege` int(5) NOT NULL,
  PRIMARY KEY  (`Themen_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `kalender`
-- 

CREATE TABLE `kalender` (
  `Termin_ID` int(5) NOT NULL auto_increment,
  `Datum` date NOT NULL,
  `Titel` varchar(128) collate latin1_general_ci NOT NULL,
  `Beschreibung` text collate latin1_general_ci NOT NULL,
  `Betrifft` varchar(10) collate latin1_general_ci NOT NULL,
  `poster_ID` int(5) NOT NULL,
  PRIMARY KEY  (`Termin_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `kontakt_nachrichten`
-- 

CREATE TABLE `kontakt_nachrichten` (
  `Kontakt_ID` int(10) NOT NULL auto_increment,
  `Gruppen_ID` int(5) NOT NULL,
  `Poster_ID` int(5) NOT NULL,
  `Beitrag` varchar(1000) character set utf8 collate utf8_unicode_ci NOT NULL,
  `Zeit` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`Kontakt_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `kurse`
-- 

CREATE TABLE `kurse` (
  `FACH_ID` tinyint(3) NOT NULL auto_increment,
  `fach_kurz` varchar(8) collate latin1_general_ci NOT NULL,
  `fach_lang` varchar(50) collate latin1_general_ci NOT NULL,
  `lehrer` varchar(50) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`FACH_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=66 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `lehrer_eintraege_neu`
-- 

CREATE TABLE `lehrer_eintraege_neu` (
  `Eintrags_ID` int(5) NOT NULL auto_increment,
  `LEHRER_ID` int(5) NOT NULL,
  `Poster_ID` int(5) NOT NULL,
  `eintragstext` varchar(1000) character set utf8 collate utf8_unicode_ci NOT NULL,
  `Zeit` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`Eintrags_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `lehrer_neu`
-- 

CREATE TABLE `lehrer_neu` (
  `LEHRER_ID` int(10) NOT NULL auto_increment,
  `Anrede` varchar(100) collate utf8_unicode_ci NOT NULL,
  `Vorname` varchar(100) collate utf8_unicode_ci NOT NULL,
  `Nachname` varchar(100) collate utf8_unicode_ci NOT NULL,
  `Eintraege` int(10) NOT NULL default '0',
  `letzter_Eintrag_Zeit` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `Geschlecht` varchar(1) collate utf8_unicode_ci NOT NULL default 'm',
  PRIMARY KEY  (`LEHRER_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=60 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `mottoergebnisse`
-- 

CREATE TABLE `mottoergebnisse` (
  `Voter_ID` int(4) NOT NULL,
  `Motto1` varchar(250) collate latin1_general_ci NOT NULL,
  `Motto2` varchar(250) collate latin1_general_ci NOT NULL,
  `Motto3` varchar(250) collate latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `motto_vorschlaege`
-- 

CREATE TABLE `motto_vorschlaege` (
  `VORSCHLAGS_ID` int(4) NOT NULL,
  `Vorschlag` varchar(1023) character set utf8 collate utf8_unicode_ci NOT NULL,
  `Beschreibung` varchar(1023) character set utf8 collate utf8_unicode_ci NOT NULL,
  `POSTER_ID` int(3) NOT NULL,
  `Postzeit` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `Votes` varchar(5) character set utf8 collate utf8_unicode_ci NOT NULL default '0',
  `Votecount` int(3) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `news`
-- 

CREATE TABLE `news` (
  `news_ID` int(5) NOT NULL auto_increment,
  `poster_ID` int(5) NOT NULL,
  `Postzeit` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `Thema` varchar(128) collate latin1_general_ci NOT NULL,
  `Text` varchar(4096) collate latin1_general_ci NOT NULL,
  `Bearbeitung` int(1) NOT NULL default '0',
  `Bearbeitungszeit` timestamp NOT NULL default '0000-00-00 00:00:00',
  `DELETED` int(1) NOT NULL default '0',
  PRIMARY KEY  (`news_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `poebel_eigenschaften`
-- 

CREATE TABLE `poebel_eigenschaften` (
  `SCHUELER_ID` int(11) NOT NULL,
  `anzahl_eintraege` int(11) NOT NULL,
  `letzter_eintrag` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `poebel_eintraege_neu`
-- 

CREATE TABLE `poebel_eintraege_neu` (
  `EintragsID` int(10) NOT NULL auto_increment,
  `SchuelerID` int(5) NOT NULL,
  `eintragstext` text collate utf8_unicode_ci NOT NULL,
  `PosterID` int(5) NOT NULL,
  `postzeit` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `anzahl_untereintraege` int(5) NOT NULL default '0',
  `untereintrag_zu` int(10) NOT NULL default '0',
  `votes` int(3) NOT NULL default '0',
  `DELETED` tinyint(1) NOT NULL default '0',
  `SCHUTZ` int(1) NOT NULL default '0',
  PRIMARY KEY  (`EintragsID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `poebel_votes`
-- 

CREATE TABLE `poebel_votes` (
  `Stimmen_ID` int(15) NOT NULL auto_increment,
  `Voter_ID` int(5) NOT NULL,
  `Eintrags_ID` int(10) NOT NULL,
  `stimme` int(2) NOT NULL,
  PRIMARY KEY  (`Stimmen_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `teams`
-- 

CREATE TABLE `teams` (
  `TEAM_ID` int(3) NOT NULL auto_increment,
  `team_name` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`TEAM_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `umfrageergebnisse`
-- 

CREATE TABLE `umfrageergebnisse` (
  `Umfrage_ID` int(3) NOT NULL,
  `Voter_ID` int(3) NOT NULL,
  `stimme` varchar(50) character set utf8 collate utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `umfragen`
-- 

CREATE TABLE `umfragen` (
  `Umfrage_ID` int(5) NOT NULL auto_increment,
  `Typ` int(3) NOT NULL COMMENT '1: alle Schüler;2: Schüler W; 3 Schüler M; 4 Lehrer alle; 5 Leher W; 6 Lehrer M; 7 andere',
  `Text` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  `max_stimmen` int(3) NOT NULL,
  `anzahl_stimmen` int(3) NOT NULL,
  `Antworten` varchar(1000) collate latin1_general_ci NOT NULL,
  `beendet` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`Umfrage_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `user`
-- 

CREATE TABLE `user` (
  `SCHUELER_ID` int(11) NOT NULL,
  `Deleted` tinyint(1) NOT NULL,
  `Nachname` varchar(255) character set utf8 collate utf8_unicode_ci default NULL,
  `Vorname` varchar(255) character set utf8 collate utf8_unicode_ci default NULL,
  `Name_ganz` varchar(200) character set utf8 collate utf8_unicode_ci NOT NULL,
  `Name_kurz` varchar(50) character set utf8 collate utf8_unicode_ci NOT NULL,
  `Geschlecht` varchar(1) NOT NULL default 'm',
  `EMail` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  `ICQ` varchar(10) NOT NULL,
  `Telefon` varchar(20) character set utf8 collate utf8_unicode_ci NOT NULL,
  `Handy` varchar(20) character set utf8 collate utf8_unicode_ci NOT NULL,
  `Strasse` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  `PLZ` varchar(5) NOT NULL,
  `Ort` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  `Kurse` varchar(255) character set utf8 collate utf8_unicode_ci default NULL,
  `Teams` varchar(1000) character set utf8 collate utf8_unicode_ci default NULL,
  `geb_d` int(2) NOT NULL,
  `geb_m` int(2) NOT NULL,
  `geb_y` int(4) NOT NULL,
  `Hobbies` text character set utf8 collate utf8_unicode_ci NOT NULL,
  `Lieblingsmusik` varchar(1000) character set utf8 collate utf8_unicode_ci NOT NULL,
  `Lieblingsbuecher` varchar(1000) character set utf8 collate utf8_unicode_ci NOT NULL,
  `Lieblingsfilme` varchar(1000) character set utf8 collate utf8_unicode_ci NOT NULL,
  `Lieblingssendungen` varchar(1000) character set utf8 collate utf8_unicode_ci NOT NULL,
  `mag` text character set utf8 collate utf8_unicode_ci NOT NULL,
  `mag_nicht` text character set utf8 collate utf8_unicode_ci NOT NULL,
  `Passwort` varchar(32) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`SCHUELER_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `zeitung`
-- 

CREATE TABLE `zeitung` (
  `Schreiber_ID` varchar(10) collate latin1_general_ci NOT NULL,
  `Artikel` varchar(10) collate latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
