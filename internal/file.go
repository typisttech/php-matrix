package internal

import (
	"os"
	"strings"
)

func sanitizeFilename(n string) string {
	n = strings.ToLower(n)

	return strings.Map(func(r rune) rune {
		if (r >= 'a' && r <= 'z') ||
			(r >= '0' && r <= '9') ||
			r == '-' ||
			r == '_' ||
			r == '.' {
			return r
		}
		return '_'
	}, n)
}

func ensureDirEmpty(path string) error {
	if err := os.RemoveAll(path); err != nil {
		return err
	}

	if err := os.MkdirAll(path, 0755); err != nil {
		return err
	}

	return nil
}
