!function (e, t) {
    "object" == typeof exports && "object" == typeof module ? module.exports = t(require("moment"), require("fullcalendar")) : "function" == typeof define && define.amd ? define(["moment", "fullcalendar"], t) : "object" == typeof exports ? t(require("moment"), require("fullcalendar")) : t(e.moment, e.FullCalendar)
}("undefined" != typeof self ? self : this, function (e, t) {
    return function (e) {
        function t(r) {
            if (n[r]) return n[r].exports;
            var a = n[r] = {i: r, l: !1, exports: {}};
            return e[r].call(a.exports, a, a.exports, t), a.l = !0, a.exports
        }

        var n = {};
        return t.m = e, t.c = n, t.d = function (e, n, r) {
            t.o(e, n) || Object.defineProperty(e, n, {configurable: !1, enumerable: !0, get: r})
        }, t.n = function (e) {
            var n = e && e.__esModule ? function () {
                return e.default
            } : function () {
                return e
            };
            return t.d(n, "a", n), n
        }, t.o = function (e, t) {
            return Object.prototype.hasOwnProperty.call(e, t)
        }, t.p = "", t(t.s = 105)
    }({
        0: function (t, n) {
            t.exports = e
        }, 1: function (e, n) {
            e.exports = t
        }, 105: function (e, t, n) {
            Object.defineProperty(t, "__esModule", {value: !0}), n(106), n(1).locale("bn")
        }, 106: function (e, t, n) {
            !function (e, t) {
                t(n(0))
            }(0, function (e) {
                return e.defineLocale("bn", {
                    months: "জানুয়ারী_ফেব্রুয়ারি_মার্চ_এপ্রিল_মে_জুন_জুলাই_আগস্ট_সেপ্টেম্বর_অক্টবর_নভেম্বর_ডিসেম্বর".split("_"),
                    monthsShort: "জান_ফেব_মার_এপ্রি_মে_জুন_জুলা_আগ_সেপ্টে_অক্ট_নভ_ডিস".split("_"),
                    weekdays: "রবিবার_সোমবার_মঙ্গলবার_বুধবার_বৃহস্পতিবার_শুক্রবার_শনিবার".split("_"),
                    weekdaysShort: "বরি_সোম_মঙ্গল_বুধ_বৃহ_শুক্র_শনিব".split("_"),
                    weekdaysMin: "Su_Mo_Tu_We_Th_Fr_Sa".split("_"),
                    longDateFormat: {
                        LT: "HH:mm",
                        LTS: "HH:mm:ss",
                        L: "DD-MM-YYYY",
                        LL: "D MMMM YYYY",
                        LLL: "D MMMM YYYY HH:mm",
                        LLLL: "dddd D MMMM YYYY HH:mm"
                    },
                    calendar: {
                        sameDay: "[Today at] LT",
                        nextDay: "[Tomorrow at] LT",
                        nextWeek: "dddd [at] LT",
                        lastDay: "[Yesterday at] LT",
                        lastWeek: "[Last] dddd [at] LT",
                        sameElse: "L"
                    },
                    relativeTime: {
                        future: "in %s",
                        past: "%s আগে",
                        s: "a কিছু সেকেন্ড",
                        ss: "%d সেকেন্ড",
                        m: "a মিনিট",
                        mm: "%d মিনিট",
                        h: "an ঘন্টা",
                        hh: "%d ঘন্টা",
                        d: "a দিন",
                        dd: "%d দিন",
                        M: "a মাস",
                        MM: "%d মাস",
                        y: "a বছর",
                        yy: "%d বছর"
                    },
                    dayOfMonthOrdinalParse: /\d{1,2}(st|nd|rd|th)/,
                    ordinal: function (e) {
                        var t = e % 10;
                        return e + (1 == ~~(e % 100 / 10) ? "th" : 1 === t ? "st" : 2 === t ? "nd" : 3 === t ? "rd" : "th")
                    },
                    week: {dow: 1, doy: 4}
                })
            })
        }
    })
});